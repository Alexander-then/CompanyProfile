<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tentang extends Model
{
    use HasFactory;
    protected $table='tentang_kami';
    protected $guarded=[];

    public function media(){
        return $this->BelongsTo('App\Models\Media');	
    }
}