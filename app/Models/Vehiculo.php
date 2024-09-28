<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculo';
    public $timestamps=false;
    protected $primaryKey = 'idvehiculo';

    protected $fillable = [
    'placa', 
    'marca', 
    'descripcion', 
    'fecha_registro',
    'estado'
];
    // Relación con el modelo DetalleFV (un flete tiene muchos detalles)
/*    public function detalles()
    {
        return $this->hasMany(DetalleFV::class, 'idflete', 'idflete');
    }*/
}
