<?php

namespace RafflesArgentina\ActionBasedFormRequest;

use Illuminate\Foundation\Http\FormRequest;

class ActionBasedFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (method_exists($this, 'sanitize')) {
            call_user_func([get_called_class(), 'sanitize']);
        }

        $action = $this->_getAction();

        if (method_exists($this, $action)) {
            return call_user_func([get_called_class(), $action]);
        }

        return [];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get action from Route object.
     *
     * @return string
     */
    private function _getAction()
    {
        return explode('@', $this->route()->getActionName())[1];
    }
}
