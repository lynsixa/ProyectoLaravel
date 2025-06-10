<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'apellido', 'documento', 'correo', 'fechadenacimiento', 'password', 'tipo_documento_id',
    ];

    // Si necesitas definir las relaciones, puedes hacerlo aquí, por ejemplo:
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }
}
