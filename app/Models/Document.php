<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'size',
        'document_path',
        'user_id',
        'folder_id',
    ];


        public function user(){
            return $this->belongsTo('App\Models\User');
        }


        public function folder(){
            return $this->belongsTo('App\Models\Folder');
        }


        public function tags(){
            return $this->morphMany('App\Models\Tag','tagable');
        }
}
