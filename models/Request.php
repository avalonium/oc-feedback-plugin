<?php namespace Avalonium\Feedback\Models;

use DB;
use Http;
use Model;
use Event;
use Cache;
use Avalonium\Feedback\Factories\RequestFactory;

/**
 * Request Model
 */
class Request extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    const STATUS_NEW = 'new';
    const STATUS_PROCESSED = 'processed';
    const STATUS_CANCELED = 'canceled';

    const SCOREBOARD_CACHE_KEY = 'ava-scoreboard-feedback-requests';

    /**
     * @var string table associated with the model
     */
    public $table = 'avalonium_feedback_requests';

    /**
     * @var array guarded attributes aren't mass assignable
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'utm'
    ];

    /**
     * @var array Json fields
     */
    protected $jsonable  = ['utm'];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'number' => 'string',
        'status' => 'string|in:new,processed,canceled',
        'name' => 'string',
        'email' => 'string|email',
        'phone' => 'string',
        'message' => 'string'
    ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [
        'number' => 'string',
        'status' => 'string',
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'message' => 'string',
        'utm' => 'string'
    ];

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    //
    // Relations
    //

    public $morphMany = [
        'logs' => [
            Log::class, 'name' => 'loggable'
        ]
    ];

    //
    // Events
    //

    public function beforeCreate()
    {
        $this->updateStatus(self::STATUS_NEW);
    }

    public function afterCreate()
    {
        $this->touchNumber();
        Event::fire('avalonium.feedback.request_created', [$this]);
    }

    public function afterSave()
    {
        Cache::forget(self::SCOREBOARD_CACHE_KEY);
    }

    /**
     *
     */
    public function getIsClosedAttribute(): bool
    {
        return match ($this->status) {
            self::STATUS_PROCESSED, self::STATUS_CANCELED => true, default => false
        };
    }

    /**
     * Update exchange status
     * @throws \Exception
     */
    private function updateStatus(string $status): void
    {
        $this->setAttribute('status', $status);
    }

    /**
     * Touch number
     * @throws \Exception
     */
    private function touchNumber(): void
    {
        $this->setAttribute('number', str('#')->append(str_pad($this->id, 6, "0", STR_PAD_LEFT))->value());
        $this->save();
    }

    /**
     * Process Exchange
     * @throws \Exception
     */
    public function process(): void
    {
        $this->setAttribute('status', self::STATUS_PROCESSED);
        $this->save();
    }

    /**
     * Cancel Exchange
     * @throws \Exception
     */
    public function cancel(): void
    {
        $this->setAttribute('status', self::STATUS_CANCELED);
        $this->save();
    }

    public function sendData($url)
    {
        $response = Http::get($url, [
            'name' => $this->name,
            'mail' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
            'utm_source' => array_get($this->utm, 'utm_source'),
            'utm_medium' => array_get($this->utm, 'utm_medium'),
            'utm_campaign' => array_get($this->utm, 'utm_campaign'),
            'utm_content' => array_get($this->utm, 'utm_content'),
            'utm_term' => array_get($this->utm, 'utm_term')
        ]);

        $this->logs()->create([
            'type' => 'updated',
            'message' => __('Request with number :number has been sent', ['number' => $this->number]),
            'details' => [
                'url' => $url,
                'status' => $response->status()
            ]
        ]);
    }

    /**
     * Count New Requests
     */
    public static function countNewRequests(): int
    {
        return self::where('status', self::STATUS_NEW)->count();
    }

    /**
     * Get Scoreboard data
     */
    public static function getScoreboardData()
    {
        if (Cache::missing(self::SCOREBOARD_CACHE_KEY)) {
            Cache::add(self::SCOREBOARD_CACHE_KEY,
                DB::table('avalonium_feedback_requests')
                    ->select(DB::raw('count(*) as requests_count'))
                    ->addSelect(DB::raw('sum(case when status = "'.self::STATUS_NEW.'" then 1 else 0 end) as new_requests_count'))
                    ->addSelect(DB::raw('sum(case when status = "'.self::STATUS_PROCESSED.'" then 1 else 0 end) as processed_requests_count'))
                    ->addSelect(DB::raw('sum(case when status = "'.self::STATUS_CANCELED.'" then 1 else 0 end) as canceled_requests_count'))
                    ->first());
        }

        return Cache::get(self::SCOREBOARD_CACHE_KEY);
    }

    /**
     * Get Model Factory
     */
    protected static function newFactory(): RequestFactory
    {
        return RequestFactory::new();
    }
}
