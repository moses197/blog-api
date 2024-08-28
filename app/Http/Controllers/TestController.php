<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $data = [
            ['id' => 1, 'name' => 'Item 1', 'value' => 'Value 1'],
            ['id' => 2, 'name' => 'Item 2', 'value' => 'Value 2'],
            ['id' => 3, 'name' => 'Item 3', 'value' => 'Value 3'],
        ];   

        return response()->json($data);
    }
}
