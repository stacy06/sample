<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
    * 头像处理
    */
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->atrributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
    /**
    * 模型类完成初始化之后加载执行
    */
    public static function boot()
    {
        parent::boot();
        static::creating(function($user){
            $user->activation_token = str_random(30);
        });
    }
}
