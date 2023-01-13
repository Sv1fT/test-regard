<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'lastName',
    ];

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->lastName . " - " . $this->firstName,
        );
    }
}
