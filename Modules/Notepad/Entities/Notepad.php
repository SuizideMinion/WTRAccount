<?php

namespace Modules\Notepad\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notepad extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'text', 'user_id'];

    protected static function newFactory()
    {
        return \Modules\Notepad\Database\factories\NotepadFactory::new();
    }
}
