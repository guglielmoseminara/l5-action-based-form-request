<?php

namespace RafflesArgentina\ActionBasedFormRequest\Traits;

use RafflesArgentina\ActionBasedFormRequest\ActionBasedFormRequest;

trait WorksWithFormRequests
{
    /**
     * The FormRequest object.
     *
     * @var ActionBasedFormRequest $formRequest
     */
    protected $formRequest;

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
        $action = $this->getActionReplaced();

        $rules = [];
        if (method_exists($this->formRequest, $action)) {
            $rules = call_user_func([$this->formRequest, $action]);
        }

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
        $action = $this->getActionReplaced();

        $rules = [];
        if (method_exists($this->formRequest, $action)) {
            $rules = call_user_func([$this->formRequest, $action]);
        }

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
        if (!$this->formRequest instanceof ActionBasedFormRequest) {
            return new $this->formRequest;
        }

        return $this->formRequest;
    }
}
