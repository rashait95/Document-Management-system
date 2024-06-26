<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    

    protected $fillable = ['tag_name','tag_id','tag_type'];


    public function tagable(){
    return $this->morphTo();
    }
}


