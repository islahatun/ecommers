<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;

    protected $guarded  =['id'];
    protected $with     = ['users','products','expeditions','packages','banks'];

    public function users(){
        return $this->belongsTo(user::class);
    }

    public function products(){
        return $this->belongsTo(product::class);
    }

    public function expeditions(){
        return $this->belongsTo(expedisi::class)->withDefault([
            'expedition_name'=>''
        ]);
    }

    public function packages(){
        return $this->belongsTo(package::class)->withDefault([
            'package_name'=>''
        ]);
    }

    public function banks(){
        return $this->belongsTo(bank::class)->withDefault([
            'bank_name'=>''
        ]);
    }
}
