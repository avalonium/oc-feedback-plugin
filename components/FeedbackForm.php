<?php namespace Avalonium\Feedback\Components;

use Flash;
use Input;
use Session;
use Request;
use Validator;
use Exception;
use ValidationException;
use Cms\Classes\ComponentBase;
use Avalonium\Feedback\Models\Feedback as FeedbackModel;

/**
 * Form Component
 */
class FeedbackForm extends ComponentBase
{
    /**
     * Component details
     */
    public function componentDetails(): array
    {
        return [
            'name' => 'Feedback Form',
            'description' => 'Display a feedback form on the page'
        ];
    }

    /**
     * Component properties
     */
    public function defineProperties(): array
    {
        return [
            'url' => [
                'title' => __('CRM Endpoint'),
                'description' => '',
                'default' => null,
                'type' => 'string'
            ],
            'successMessage' => [
                'title'             => __('Success message'),
                'description'       => __('The message displayed on the site when form is processed'),
                'type'              => 'string',
                'default'           => __('Request successful created'),
                'showExternalParam' => false,
            ],
        ];
    }

    /**
     * Handler onRun
     */
    public function onRun(): void
    {
        $this->trackUtmMarks();
    }

    /**
     * onCreateFeedback ajax handler
     */
    public function onCreateFeedback()
    {
        try {
            $data = post();
            $rules = (new FeedbackModel())->rules;

            $validation = Validator::make($data, $rules);

            if ($validation->fails()) {
                throw new ValidationException($validation);
            }

            $feedback = new FeedbackModel();
            $feedback->fill($data);
            $feedback->save();

            if ($url = $this->property('url')) {
                $feedback->sendData($url, Session::get('avalonium-feedback-utm', []));
            }

            Flash::success($this->property('successMessage'));

        } catch (Exception $ex) {
            if (Request::ajax()) {
                throw $ex;
            } else {
                Flash::error($ex->getMessage());
            }
        }
    }

    private function trackUtmMarks():void
    {
        Session::put('avalonium-feedback-utm', [
            'utm_source' => Input::get('utm_source'),
            'utm_medium' => Input::get('utm_medium'),
            'utm_campaign' => Input::get('utm_campaign'),
            'utm_content' => Input::get('utm_content'),
            'utm_term' => Input::get('utm_term')
        ]);
    }
}
