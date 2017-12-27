<?php

namespace RafflesArgentina\ActionBasedFormRequest;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TestController extends Controller
{
    public function index(TestFormRequest $request)
    {
        return response()->json([]);
    }

    public function store(TestFormRequest $request)
    {
        return response()->json([]);
    }

    public function update(TestFormRequest $request, $id)
    {
        return response()->json([]);
    }
}
