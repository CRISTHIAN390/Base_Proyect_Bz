<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;
    protected $table = 'empleado';
    protected $primaryKey = 'idempleado';
    public $timestamps = false;
    protected $fillable = ['apellidos', 'nombres', 'celular', 'dni', 'estado'];

    // Relación con el modelo DetalleFV (un empleado tiene muchos detalles)
    public function detalles()
    {
        return $this->hasMany(DetalleFV::class, 'idempleado','idempleado');
    }
}
