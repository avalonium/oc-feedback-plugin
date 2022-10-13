<?php namespace Avalonium\Feedback\Controllers;

use Flash;
use Event;
use BackendMenu;
use ApplicationException;
use Backend\Classes\Controller;
use System\Classes\SettingsManager;
use Avalonium\Feedback\Models\Log;
use Avalonium\Feedback\Models\Request;

/**
 * Requests Backend Controller
 */
class Requests extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\RelationController::class
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';

    /**
     * @var string relationConfig file
     */
    public $relationConfig = 'config_relation.yaml';

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        SettingsManager::setContext('Avalonium.Feedback', 'feedback');
        BackendMenu::setContext('October.System', 'system', 'settings');
    }

    /**
     * Process request ajax handler
     */
    public function preview_onProcess(): mixed
    {
        /** @var Request $model */
        $model = $this->formGetModel();
        $model->process();

        Event::fire('avalonium.feedback.request_processed', [$model]);
        Flash::success(__("Request successful processed"));

        return $this->formRefreshFields(['logs']);
    }

    /**
     * Cancel request ajax handler
     */
    public function preview_onCancel(): mixed
    {
        /** @var Request $model */
        $model = $this->formGetModel();
        $model->cancel();

        Event::fire('avalonium.feedback.request_canceled', [$model]);
        Flash::success(__("Request successful canceled"));

        return $this->formRefreshFields(['logs']);
    }

    /**
     * On view details Handler
     */
    public function preview_onViewDetails($red): mixed
    {
        if (!$model = Log::find(post('record_id'))) {
            throw new ApplicationException('Model does not found');
        }

        $this->vars['details'] = $model->details;

        return $this->makePartial('modal_details');
    }
}
