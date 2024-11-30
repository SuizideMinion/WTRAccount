<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\TimeManagment\Entities\TimeTracking;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firma',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function userPermission()
    {
        return $this->hasMany(UserPermission::class)->pluck('user_id', 'key');
    }

    public function userData()
    {
        return $this->hasMany(UserData::class)->pluck('value', 'key');
    }

    // Neue Methode für den Controller
    public function userDataRelation()
    {
        return $this->hasMany(UserData::class);
    }

    public function userDataLike($id)
    {
        return $this->hasMany(UserData::class)->where('key', 'like', $id . '%')->pluck('value', 'key');
    }

    public function userHasPermission()
    {
        return $this->hasMany(UserPermission::class, 'user_id', 'id')->pluck('user_id', 'key');
    }

    public function userAktive()
    {
        return (TimeTracking::where('user_id', $this->id)->where('stamped_out', '!', 0)->first() ?? false);
    }

    public function getWorktime($from, $to)
    {
        return TimeTracking::where('user_id', $this->id)->where('stamped', '<', $to)->where('stamped', '>', $from)->sum('time_worked');
    }
    public function timeEntries()
    {
        return $this->hasMany(TimeEntry::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
