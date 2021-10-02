<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable;

    protected static function booted()
    {
        static::addGlobalScope('withPassword', function ($builder) {
            $builder
                ->join('membership_card', 'users.id', '=', 'membership_card.user_id')
                ->select(DB::raw('membership_card.password, users.*'));
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function coupons(){
        return $this->hasMany(Coupon::class);
    }

    public function favorites(){
        return $this->belongsToMany(Writer::class, 'favorites', 'user_id', 'writer_id');
    }

    public function image(){
        return $this->hasOne(ProfileImage::class);
    }
    
}
