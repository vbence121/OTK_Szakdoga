<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HerdBookType;

class HerdBookTypeController extends Controller
{
    public function getHerdBookTypes()
    {
        return HerdBookType::all();
    }
}
