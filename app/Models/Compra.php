<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_hora',
        'impuesto',
        'numero_comprobante',
        'total',
        'comprobante_id',

    ];



    public function comprobante()
    {
        return $this->belongsTo(Comprobante::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class)->withTimestamps()
            ->withPivot('cantidad', 'precio_compra', 'precio_venta');
    }
}
