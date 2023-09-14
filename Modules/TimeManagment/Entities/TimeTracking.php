<?php

namespace Modules\TimeManagment\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeTracking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'stamped', 'stamped_out', 'working_time'];

    protected static function newFactory()
    {
        return \Modules\TimeManagment\Database\factories\TimeTrackingFactory::new();
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
