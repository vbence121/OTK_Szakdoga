<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EventCategory;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;

class DogJudging extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'breed',
        'hobby',
        'gender',
        'birthdate',
        'user_id',
        'dog_id',
        'breederName',
        //'description',
        'motherName',
        'fatherName',
        'breed_id',
        'registerSernum',
        'herd_book_type_id',
        'status',   // pending/approved/declined/paid
        'event_category_id',
        'result',
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
        'birthdate' => 'datetime',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(File::class,'dog_id','dog_id');
    }

    public function breed()
    {
        return $this->belongsTo(Breed::class, 'breed_id', 'id');
    }

    public function event_category_id()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id', 'id');
    }

    /*
    public function events()
    {
        return $this->belongsToMany(Event::class, 'registered_dogs');
    }
    */
}
