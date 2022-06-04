<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class Receta extends Model
{
    use HasFactory;

    protected $fillable =['title', 'content', 'category'];

    //pasar un arreglo, filtrando por title y category
    public static function search($input)
    {
        
        $receta = new self();

        if(isset($input['title'])){
            $receta = $receta->where('title', $input['title']);
        }
        if(isset($input['category'])){
            $receta = $receta->where('category', $input['category']);
        }
        return $receta->get();
    }
}
