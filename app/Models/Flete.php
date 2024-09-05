<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flete extends Model
{
    protected $table = 'flete';
    public $timestamps=false;
    protected $primaryKey = 'idflete';

    protected $fillable = ['nombre_flete', 'descripcion', 'estado'];
    // Relación con el modelo DetalleFV (un flete tiene muchos detalles)
    public function detalles()
    {
        return $this->hasMany(DetalleFV::class, 'idflete', 'idflete');
    }
}
