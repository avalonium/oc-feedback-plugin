<?php namespace Avalonium\Feedback\Models;

use Model;
use Avalonium\Feedback\Factories\FeedbackFactory;

/**
 * Feedback Model
 */
class Feedback extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    const STATUS_NEW = 'new';
    const STATUS_PROCESSED = 'processed';
    const STATUS_CANCELED = 'canceled';

    /**
     * @var string table associated with the model
     */
    public $table = 'avalonium_feedback';

    /**
     * @var array guarded attributes aren't mass assignable
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = [];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'number' => 'string',
        'status' => 'required:update|string|in:new,processed,canceled',
        'name' => 'string',
        'phone' => 'string',
        'message' => 'required|string'
    ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [
        'number' => 'string',
        'status' => 'string',
        'name' => 'string',
        'phone' => 'string',
        'message' => 'string'
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
    // Events
    //

    public function beforeCreate()
    {
        $this->updateStatus(self::STATUS_NEW);
    }

    public function afterCreate()
    {
        $this->touchNumber();
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
     * Touch Exchange number
     * @throws \Exception
     */
    private function touchNumber(): void
    {
        $this->setAttribute('number', str('#')->append(str_pad($this->id, 6, "0", STR_PAD_LEFT))->value());
        $this->save();
    }

    /**
     * Get Model Factory
     */
    protected static function newFactory(): FeedbackFactory
    {
        return FeedbackFactory::new();
    }
}
