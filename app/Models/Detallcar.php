<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detallcar extends Model
{
    use HasFactory;

    protected $table = 'detallevehiculo';

    protected $primaryKey = 'iddetalleveh';
    public $timestamps=false;
    protected $fillable = ['idvehiculo', 'idempleado', 'fecha', 'observacion', 'monto', 'estado'];


    // Relación con el modelo Empleado (muchos detalles pertenecen a un empleado)
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'idempleado', 'idempleado');
    }

    // Relación con el modelo Flete (muchos detalles pertenecen a un flete)
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'idvehiculo', 'idvehiculo');
    }

}
