<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto';
    protected $primaryKey = 'idProducto';
    public $timestamps = false;

    protected $fillable = [
        'Precio', 'Disponibilidad', 'Cantidad',
        'CodigoNis_idCodigoNis', 'Categoria_idCategoria'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'Categoria_idCategoria', 'idCategoria');   
     }
}
