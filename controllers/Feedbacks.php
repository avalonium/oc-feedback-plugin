<?php namespace Avalonium\Feedback\Controllers;

use Flash;
use Event;
use BackendMenu;
use Backend\Classes\Controller;
use System\Classes\SettingsManager;
use Avalonium\Feedback\Models\Feedback;

/**
 * Feedbacks Backend Controller
 */
class Feedbacks extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class
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
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        SettingsManager::setContext('Avalonium.Feedback', 'feedback');
        BackendMenu::setContext('October.System', 'system', 'settings');
    }

    /**
     * Process feedback ajax handler
     */
    public function preview_onProcess(): void
    {
        /** @var Feedback $model */
        $model = $this->formGetModel();
        $model->process();

        Flash::success(__("Request successful processed"));
    }

    /**
     * Cancel feedback ajax handler
     */
    public function preview_onCancel(): void
    {
        /** @var Feedback $model */
        $model = $this->formGetModel();
        $model->cancel();

        Flash::success(__("Request successful canceled"));
    }
}
