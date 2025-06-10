<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    protected $table = 'mesa';  // Nombre de la tabla en la base de datos
    protected $primaryKey = 'idMesa';  // Clave primaria
    protected $fillable = ['NumeroPiso', 'NumeroMesa'];  // Asegúrate de que estos campos existan en tu tabla
    public $timestamps = false;

    // Relación con NIS
    public function nis()
    {
        return $this->hasMany(NIS::class, 'Mesa_idMesa');  // Asegúrate de que el campo en NIS sea correcto
    }
}
