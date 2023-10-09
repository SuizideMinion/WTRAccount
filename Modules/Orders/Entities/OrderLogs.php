<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderLogs extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'value', 'user_id'];

    protected static function newFactory()
    {
        return \Modules\Orders\Database\factories\OrderLogsFactory::new();
    }
}
