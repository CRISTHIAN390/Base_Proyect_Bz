<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viatico extends Model
{
    use HasFactory;
    protected $table = 'viatico';
    public $timestamps=false;
    protected $primaryKey = 'idviatico';

    protected $fillable = ['nombre_viatico', 'descripcion', 'estado'];

    // Relación con el modelo DetalleFV (un viatico tiene muchos detalles)
    public function detalles()
    {
        return $this->hasMany(DetalleFV::class, 'idviatico', 'idviatico');
    }
}
