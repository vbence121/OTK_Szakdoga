<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogue;
use Illuminate\Support\Facades\DB;

class CatalogueController extends Controller
{
    public function getAllCatalogues()
    {
        $catalouges = Catalogue::all();

        $oldCatalogues = [];
        foreach($catalouges as $key => $catalogue){
            $relatedExhibition = $catalogue->exhibition()->get()[0];
            $selectedExhibitionDate = date('Y-m-d', strtotime($relatedExhibition->date));
            $now = date('Y-m-d');
            if($selectedExhibitionDate < $now){
                $oldCatalogues[] = $catalogue;
                unset($catalouges[$key]);
            }
        }

        return response([
            'catalogues' => $catalouges,
            'oldCatalogues' => $oldCatalogues,
        ]);
    }

    public function getCatalogueById($catalogue_id)
    {
        $dogs = DB::table('registered_dogs')
            ->join('event_categories', 'event_categories.id', '=', 'registered_dogs.event_category_id')
            ->where('event_categories.catalogue_id', '=', $catalogue_id)
            ->join('dog_judgings', 'dog_judgings.dog_id', '=', 'registered_dogs.dog_id')
            ->join('breeds', 'breeds.id', '=', 'dog_judgings.breed_id')
            ->join('breed_groups', 'breeds.breed_group_id', '=', 'breed_groups.id')
            ->join('categories', 'categories.id', '=', 'event_categories.category_id')
            ->join('dog_classes', 'dog_classes.id', '=', 'registered_dogs.dog_class_id')
            ->join('users', 'users.id', '=', 'registered_dogs.user_id')
            ->select(
                'registered_dogs.*', 
                'breed_groups.name as breedGroupName', 
                'categories.type as categoryName', 
                'dog_judgings.gender',
                'breeds.name as breedName',
                'dog_judgings.breed_id',
                'dog_judgings.name',
                'dog_classes.type as className',
                'dog_judgings.registerSernum',
                'dog_judgings.birthdate',
                'dog_judgings.motherName',
                'dog_judgings.fatherName',
                'dog_judgings.breederName',
                'users.name as ownerName',
            )
            ->orderBy('registered_dogs.start_number')
            ->get();

        return response([
            'catalogue' => $dogs,
            'selectedCatalogue' => Catalogue::find($catalogue_id),
        ]);
    }

    public function getCatalogueByExhibitionId(Request $request)
    {
        $fields = $request->validate([
            'exhibition_id' => 'required|numeric',
        ]);

        return response([
            'catalogue' => DB::table('catalogues')->where('exhibition_id', '=', $fields['exhibition_id'])->get(),
        ]);
    }
}
