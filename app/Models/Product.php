<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'char';

    public function brands(){
        return $this->belongsTo(Brand::class);
    }

    public function categories(){
        return $this->belongsTo(Categorie::class);
    }
}
