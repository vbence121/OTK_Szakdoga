<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dog;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentCertificateFile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'generated_name',
        'dog_id',
        'event_id',
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

    public function dogs()
    {
        return $this->belongsTo(Dog::class, 'dog_id', 'id');
    }
}
