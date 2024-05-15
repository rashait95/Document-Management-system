<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'size ',
        'folder_path',
        'created_at',
        'parent_id',
    ];

    public function parent()
    {
        
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function children()
    {
        
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
   

    public function documents()
    {
        
        return $this->hasMany('App\Models\Document');
    }

  


}
