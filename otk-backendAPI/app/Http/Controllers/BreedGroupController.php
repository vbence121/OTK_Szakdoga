<?php

namespace App\Http\Controllers;
use App\Models\BreedGroup;
use Illuminate\Http\Request;

class BreedGroupController extends Controller
{
    public function getBreedGroupsWithBreeds()
    {
        $breedGroups = BreedGroup::all();

        for ($i = 0; $i < count($breedGroups); $i++) {
           $breedGroups[$i]->breeds = $breedGroups[$i]->breeds()->get(); 
        }
        
        return $breedGroups;
    }
}
