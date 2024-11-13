<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;
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
    public function detallecar()
    {
        return $this->hasMany(Detallcar::class, 'idvehiculo','idvehiculo');
    }
}
