<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EventCategory;
use App\Models\Ring;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Exhibition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'date',
        'added_to_homepage',
        'entry_deadline',
        'active',
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

    public function events()
    {
        return $this->hasMany(EventCategory::class,'exhibition_id','id');
    }
    public function rings()
    {
        return $this->hasMany(Ring::class,'exhibition_id','id');
    }
}
