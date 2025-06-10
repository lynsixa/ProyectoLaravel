<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';  // Asegúrate de que la tabla esté bien definida
    protected $primaryKey = 'idMenu';
    protected $fillable = ['Descripcion'];
    public $timestamps = false;

    // Relación con NIS
    public function nis()
    {
        return $this->hasMany(NIS::class, 'Menu_idMenu');
    }
}
