<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'is_available'])]
class Flavor extends Model
{
    use HasFactory;
    
    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
        ];
    }
}
