<?php

namespace RafflesArgentina\ActionBasedFormRequest;

class TestFormRequest extends ActionBasedFormRequest
{
    public static function index()
    {
        return [
            'show' => 'numeric|min:1|max:400',
        ];
    }

    public static function store()
    {
        return [
            'title' => 'required|max:100',
        ];
    }

    public static function update()
    {
        return [
            'title' => 'required|max:100',
        ];
    }
}
