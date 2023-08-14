<?php

namespace App\Http\Controllers;

use App\Helpers\Lyn;
use Illuminate\Http\Request;

class BroadcastController extends Controller
{
    public function index()
    {
        return Lyn::view('broadcast.index');
    }
}
