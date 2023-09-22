<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'filesize',
        'folder_id'
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
}
