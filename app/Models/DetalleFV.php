<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFV extends Model
{
    use HasFactory;

    protected $table = 'detallefv';

    protected $primaryKey = 'iddetallefv';
    public $timestamps=false;
    protected $fillable = ['idempleado', 'idflete', 'idviatico', 'fecha', 'descripcion', 'tipoIG', 'importe', 'estado'];


    // Relación con el modelo Empleado (muchos detalles pertenecen a un empleado)
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'idempleado', 'idempleado');
    }

    // Relación con el modelo Flete (muchos detalles pertenecen a un flete)
    public function flete()
    {
        return $this->belongsTo(Flete::class, 'idflete', 'idflete');
    }

    // Relación con el modelo Viatico (muchos detalles pertenecen a un viatico)
    public function viatico()
    {
        return $this->belongsTo(Viatico::class, 'idviatico', 'idviatico');
    }
}
