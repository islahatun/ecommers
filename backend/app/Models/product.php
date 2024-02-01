<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $guarded  =['id'];
    protected $with     = ['categories'];

    public function categories(){
        return $this->belongsTo(category::class,'category_id','id');
    }

}
