<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderData extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'key', 'value'];

    protected static function newFactory()
    {
        return \Modules\Orders\Database\factories\OrderDataFactory::new();
    }
}
