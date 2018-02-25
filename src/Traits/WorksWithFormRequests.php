<?php

namespace RafflesArgentina\ActionBasedFormRequest\Traits;

use Illuminate\Foundation\Http\FormRequest;
use RafflesArgentina\ActionBasedFormRequest\ActionBasedFormRequest;

trait WorksWithFormRequests
{
    /**
     * Get rules from ActionBasedFormRequest or FormRequest instance.
     *
     * @return array
     */
    public function getRules()
    {
        $action = $this->getActionReplaced();
        if (method_exists($this->formRequest, $action)) {
            return call_user_func([$this->formRequest, $action]);
        }

        if (method_exists($this->formRequest, 'rules')) {
            return call_user_func([$this->formRequest, 'rules']);
        }

        return [];
    }

    /**
     * Get action from current request.
     *
     * @return string
     */
    public function getAction()
    {
        return explode('@', request()->route()->getActionName())[1];
    }

    /**
     * Get required fields.
     *
     * @return string JSON
     */
    public function getRequiredFields()
    {
        $rules = $this->getRules();

        $requiredFields = array_where(
            $rules, function ($value, $key) {
                if (is_array($value)) {
                    array_where(
                        $value, function ($v, $k) {
                            return str_contains($v, ['required', 'sometimes']);
                        }
                    );
                }

                if (is_string($value)) {
                    return str_contains($value, ['required', 'sometimes']);
                }
            }
        );

        return json_encode($requiredFields);
    }

    /**
     * Get validation rules.
     *
     * @return string JSON
     */
    public function getValidationRules()
    {
        $rules = $this->getRules();

        return json_encode($rules);
    }

    /**
     * Get action replaced by store or update when it's create or edit.
     *
     * @return string
     */
    protected function getActionReplaced()
    {
        return str_replace(
            ['create','edit'],
            ['store','update'],
            $this->getAction()
        );
    }

    /**
     * Get an instance of FormRequest.
     *
     * @return ActionBasedFormRequest
     */
    protected function getFormRequestInstance()
    {
        if ($this->formRequest) {
            return new $this->formRequest;
        }

        return new FormRequest;
    }
}
