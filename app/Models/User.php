<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\InvestorProperty;
use App\Models\PartnerProperty;
use App\Models\PermissionUser;
use App\Models\Permission;
use App\Models\UserDetail;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'role',
        'status',
        'user_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function PartnerProperties()
    {
        return $this->hasMany(PartnerProperty::class, 'user_id');
    }
    public function UserDetail()
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    public function InvestorProperties()
    {
        return $this->hasMany(InvestorProperty::class, 'user_id');
    }
    public function reports()
    {
        return $this->hasMany(UserPersonalReport::class); // 'user_id' is the foreign key in `user_personal_reports`
    }
    public function permission()
    {
        return $this->hasMany(PermissionUser::class); // 'user_id' is the foreign key in `user_personal_reports`
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_users');
    }

}
