<?php

namespace Modules\Ventas\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Productos\app\Models\Producto;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'cantidad',
        'precio_unitario',
        'total',
        'cliente',
        'observaciones'
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'total' => 'decimal:2',
        'cantidad' => 'integer'
    ];

    /**
     * Relación con producto
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Boot del modelo para calcular total automáticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($venta) {
            $venta->total = $venta->cantidad * $venta->precio_unitario;
        });

        static::updating(function ($venta) {
            $venta->total = $venta->cantidad * $venta->precio_unitario;
        });

        static::created(function ($venta) {
            // Decrementar stock del producto
            $venta->producto->decrementarStock($venta->cantidad);
        });
    }

    /**
     * Scope para filtrar por fecha
     */
    public function scopeFecha($query, $fecha)
    {
        return $query->whereDate('created_at', $fecha);
    }

    /**
     * Scope para filtrar por rango de fechas
     */
    public function scopeRangoFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
    }
}
