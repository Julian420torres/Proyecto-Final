<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuVenta extends Model
{
    use HasFactory;

    protected $table = 'menu_venta';
    protected $fillable = ['venta_id', 'menu_id', 'cantidad', 'precio_unitario', 'subtotal'];

    // Relación con Venta
    public function ventas(): BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }

    // Relación con Menú
    public function menus(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}
