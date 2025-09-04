<?php

namespace Modules\IA\app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class IAController extends Controller
{
    public function index()
    {
        return view('ia::index');
    }

    public function chatbot()
    {
        return view('ia::chatbot');
    }

    public function predicciones()
    {
        return view('ia::predicciones');
    }
}
