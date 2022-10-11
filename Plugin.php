<?php namespace Avalonium\Feedback;

use System\Classes\PluginBase;
use Avalonium\Feedback\Components\FeedbackForm;

/**
 * Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Register Plugin Components
     */
    public function registerComponents(): array
    {
        return [
            FeedbackForm::class => 'feedbackForm'
        ];
    }
}
