<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exhibition;
use Illuminate\Support\Facades\DB;

class ExhibitionController extends Controller
{
    public function getAll() 
    {
        return Exhibition::all();
    }
    public function getExhibitionById(Request $request) 
    {
        $exhibition = Exhibition::find($request->exhibition_id);

        $categories = DB::table('event_categories')
        ->join('categories', 'categories.id', '=', 'event_categories.category_id')
        ->leftJoin('hobby_categories', 'hobby_categories.id', '=', 'event_categories.hobby_category_id')
        ->where('exhibition_id', $request->exhibition_id)
        ->select(
            'event_categories.*',
            'categories.type as categoryType',
            'hobby_categories.type as hobbyCategoryType',
        )
        ->get();

        return response([
            'exhibition' => $exhibition,
            'categories' => $categories,
        ]);

        return DB::table('event_categories')
        ->join('exhibitions', 'exhibitions.id', '=', 'event_categories.exhibition_id')
        ->where('active', '1')
        ->join('categories', 'categories.id', '=', 'event_categories.category_id')
        ->leftJoin('hobby_categories', 'hobby_categories.id', '=', 'event_categories.hobby_category_id')
        ->select(
            'event_categories.*',
            'categories.type as categoryType',
            'hobby_categories.type as hobbyCategoryType',
            'exhibitions.name as name',
            'exhibitions.date as date',
        )
        ->get();
    }
}
