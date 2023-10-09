<?php

namespace Modules\Orders\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'user_id', 'auftraggeber', 'link', 'order'];

    protected static function newFactory()
    {
        return \Modules\Orders\Database\factories\OrderFactory::new();
    }

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }

    public function data()
    {
        return $this->hasMany(OrderData::class, 'order_id', 'id')->pluck('value', 'key');
    }
}
