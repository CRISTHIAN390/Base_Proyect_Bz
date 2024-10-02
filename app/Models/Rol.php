<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Rol extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'rol';
    public $timestamps=false;
    protected $primaryKey = 'idrol';

    protected $fillable = ['name', 'state'];

    public function users()
    {
        return $this->hasMany(User::class, 'idrol','id');
    }
}
