<?php

namespace Modules\Permission\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['desc', 'key'];

    protected static function newFactory()
    {
        return \Modules\Permission\Database\factories\PermissionFactory::new();
    }
}
