<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reason',
        'decision',
        'admin_id', // to store the id of the deciding admin (nullable)
    ];

    public function users()
    {
        return $this->hasMany(User::class,'user_id','id');
    }
}
