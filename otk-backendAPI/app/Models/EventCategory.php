<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BreedGroup;
use App\Models\Catalogue;
use App\Models\Dog;
use App\Models\DogClass;
use App\Models\Exhibition;
use App\Models\Category;
use App\Models\HerdBookType;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class EventCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category_id',
        'hobby_category_id',
        'catalogue_id',
        'exhibition_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        //'birthdate' => 'datetime',
    ];

    public function breedGroups()
    {
        return $this->belongsToMany(BreedGroup::class);
    }

    public function dogs()
    {
        return $this->belongsToMany(Dog::class, 'registered_dogs');
    }

    public function events()
    {
        return $this->belongsToMany(DogClass::class, 'registered_dogs');
    }

    public function herdBookTypes()
    {
        return $this->belongsToMany(HerdBookType::class, 'event_category_herd_book_type');
    }

    public function catalogues()
    {
        return $this->belongsTo(Catalogue::class,'event_category_id','id');
    }

    public function exhibitions()
    {
        return $this->belongsTo(Exhibition::class,'exhibition_id','id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
