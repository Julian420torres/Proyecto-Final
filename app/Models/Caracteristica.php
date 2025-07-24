<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Caracteristica extends Model
{
    use HasFactory;

    public function categoria()
    {
        return $this->hasOne(Categoria::class);
    }



    protected $fillable = ['nombre', 'descripcion'];
}
