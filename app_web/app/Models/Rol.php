<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'idRoles'; // Clave primaria
    public $timestamps = false; // No usamos created_at y updated_at

    protected $fillable = [

        'idRoles',
        'Descripcion'
    ]; // ✅ Esta línea permite la asignación masiva
}
