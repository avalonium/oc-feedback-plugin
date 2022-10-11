<?php namespace Avalonium\Feedback\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use System\Classes\SettingsManager;

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
}
