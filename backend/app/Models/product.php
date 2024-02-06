<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class product extends Model
{
    use HasFactory;

    // use Uuid;
    protected $guarded  =['id'];
    protected $with     = ['categories'];

    public function categories(){
        return $this->belongsTo(category::class,'category_id','id');
    }

}
