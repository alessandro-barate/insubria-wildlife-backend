<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poster extends Model
{

    public function poster()
    {

        return $this->hasOne(Poster::class);
    }

    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'price',
        'location',
        'speaker'
    ];

}
