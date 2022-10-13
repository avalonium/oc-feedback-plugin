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
    public array $marks = [
        'utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'
    ];

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
            'isRequiredName' => [
                'title' => __('Name field is required'),
                'type' => 'checkbox',
                'group' => 'Validation',
                'default' => true
            ],
            'isRequiredEmail' => [
                'title' => __('Email field is required'),
                'type' => 'checkbox',
                'group' => 'Validation',
                'default' => true
            ],
            'isRequiredPhone' => [
                'title' => __('Phone field is required'),
                'type' => 'checkbox',
                'group' => 'Validation',
                'default' => true
            ],
            'isRequiredMessage' => [
                'title' => __('Message field is required'),
                'type' => 'checkbox',
                'group' => 'Validation',
                'default' => true
            ]
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

            $rules = [
                'name' => ['required', 'string'],
                'email' => ['string', 'email'],
                'phone' => ['string'],
                'message' => ['string']
            ];

            $validation = Validator::make($data, $this->extendValidationRules($rules));

            if ($validation->fails()) {
                throw new ValidationException($validation);
            }

            $model = RequestModel::make($data);
            $model->setAttribute('utm', Session::get('avalonium-feedback-marks', []));
            $model->setAttribute('ip_address', Request::getClientIp());
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

    /**
     * Extend validation rules
     */
    private function extendValidationRules(array $rules): array
    {
        $this->property('isRequiredName') && array_push($rules['name'], 'required');
        $this->property('isRequiredEmail') && array_push($rules['email'], 'required');
        $this->property('isRequiredPhone') && array_push($rules['phone'], 'required');
        $this->property('isRequiredMessage') && array_push($rules['message'], 'required');

        return $rules;
    }

    /**
     * Put UTM marks to session
     */
    private function trackUtmMarks(): void
    {
        $data = Session::get('avalonium-feedback-marks', []);

        foreach ($this->marks as $mark) {
            Input::has($mark) && $data[$mark] = Input::get($mark);
        }

        Session::put('avalonium-feedback-marks', $data);
    }
}
