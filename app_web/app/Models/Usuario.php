<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // 👈 usamos Authenticatable, no Model
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuario';
    protected $primaryKey = 'idUsuario';
    public $timestamps = false;

    protected $fillable = [
        'Nombres',
        'Apellidos',
        'Documento',
        'Correo',
        'Contraseña',
        'FechaDeNacimiento',
        'token',
        'token_password',
        'password_request',
        'Tipo_de_documento_idTipodedocumento',
        'Roles_idRoles',
        'CodigoNis_idCodigoNis',
    ];

    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * 🔐 Sobrescribe el método que Laravel usa para obtener la contraseña
     */
    public function getAuthPassword()
    {
        return $this->Contraseña; // 👈 le indicas a Laravel que use este campo
    }

    /**
     * Relación con TipoDeDocumento
     */
    public function tipoDeDocumento()
    {
        return $this->belongsTo(TipoDeDocumento::class, 'Tipo_de_documento_idTipodedocumento', 'idTipodedocumento');
    }

    /**
     * Relación con Rol
     */
    public function roles()
    {
        return $this->belongsTo(Rol::class, 'Roles_idRoles', 'idRoles');
    }
}
