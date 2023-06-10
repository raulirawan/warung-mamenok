<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    protected $table = 'menu';
    protected $fillable = [
        'nama_menu', 'harga', 'gambar'
       ];
}
