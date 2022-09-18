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
            $relatedEvents = $catalogue->events()->get();
            $shouldPushToPastCatalogues = false;
            foreach($relatedEvents as $key => $event){
                $selectedEventDate = date('Y-m-d', strtotime($event->date));
                $now = date('Y-m-d');
                if($selectedEventDate < $now){
                    $shouldPushToPastCatalogues = true;
                }
            }
            if($shouldPushToPastCatalogues){
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
            ->join('events', 'events.id', '=', 'registered_dogs.event_id')
            ->where('events.catalogue_id', '=', $catalogue_id)
            ->join('dogs', 'dogs.id', '=', 'registered_dogs.dog_id')
            ->join('breeds', 'breeds.id', '=', 'dogs.breed_id')
            ->join('breed_groups', 'breeds.breed_group_id', '=', 'breed_groups.id')
            ->join('categories', 'categories.id', '=', 'events.category_id')
            ->join('dog_classes', 'dog_classes.id', '=', 'registered_dogs.dog_class_id')
            ->join('users', 'users.id', '=', 'registered_dogs.user_id')
            ->select(
                'registered_dogs.*', 
                'breed_groups.name as breedGroupName', 
                'categories.type as categoryName', 
                'dogs.gender',
                'breeds.name as breedName',
                'dogs.breed_id',
                'dogs.name',
                'dog_classes.type as className',
                'dogs.registerSernum',
                'dogs.birthdate',
                'dogs.motherName',
                'dogs.fatherName',
                'dogs.breederName',
                'users.name as ownerName',
            )
            ->orderBy('registered_dogs.start_number')
            ->get();

        return response([
            'catalogue' => $dogs,
            'selectedCatalogue' => Catalogue::find($catalogue_id),
        ]);
    }
}
