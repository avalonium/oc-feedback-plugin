<?php namespace Avalonium\Feedback;

use System\Classes\PluginBase;
use Avalonium\Feedback\Components\Form;

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
            Form::class => 'feedbackForm'
        ];
    }
}
