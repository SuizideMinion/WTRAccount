<?php

namespace Modules\TimeManagment\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestTimeChance extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'time_id', 'stamped', 'stamped_out'];

    protected static function newFactory()
    {
        return \Modules\TimeManagment\Database\factories\RequestTimeChanceFactory::new();
    }

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }

    public function time()
    {
        return $this->hasOne(TimeTracking::class, 'time_id', 'id');
    }
}
