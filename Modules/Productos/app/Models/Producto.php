<?php

namespace Modules\Productos\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'sku',
        'precio',
        'stock',
        'descripcion',
        'categoria'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer'
    ];

    /**
     * Relación con ventas
     */
    public function ventas()
    {
        return $this->hasMany(\Modules\Ventas\app\Models\Venta::class);
    }

    /**
     * Scope para buscar por nombre
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('nombre', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
    }

    /**
     * Verificar si hay stock suficiente
     */
    public function tieneStock($cantidad)
    {
        return $this->stock >= $cantidad;
    }

    /**
     * Decrementar stock
     */
    public function decrementarStock($cantidad)
    {
        if ($this->tieneStock($cantidad)) {
            $this->decrement('stock', $cantidad);
            return true;
        }
        return false;
    }
}
