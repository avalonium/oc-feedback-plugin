<?php namespace Avalonium\Feedback\Components;

use Flash;
use Input;
use Session;
use Request;
use Validator;
use Exception;
use ValidationException;
use Cms\Classes\ComponentBase;
use Avalonium\Feedback\Models\Request as RequestModel;

/**
 * Form Component
 */
class Form extends ComponentBase
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
            $rules = (new RequestModel())->rules;

            $validation = Validator::make($data, $rules);

            if ($validation->fails()) {
                throw new ValidationException($validation);
            }

            $utm = Session::get('avalonium-feedback-utm', []);

            $model = new RequestModel();
            $model->ip_address = Request::getClientIp();
            $model->fill($data);
            $model->utm = $utm;
            $model->save();

            if ($url = $this->property('url')) {
                $model->sendData($url);
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
