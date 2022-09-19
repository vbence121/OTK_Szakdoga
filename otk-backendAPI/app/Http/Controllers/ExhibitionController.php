<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exhibition;

class ExhibitionController extends Controller
{
    public function getAll() 
    {
        return Exhibition::all();
    }
}
