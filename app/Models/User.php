<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password',
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
     * 复用设置手机号查询条件方法.
     *
     * @param Builder $query 查询对象
     * @param string  $phone 手机号码
     *
     * @return Builder 查询对象
     *
     * @author Seven Du <shiweidu@outlook.com>
     * @homepage http://medz.cn
     */
    public function scopeByPhone(Builder $query, string $phone): Builder
    {
        return $query->where('phone', $phone);
    }

    /**
     * 复用设置用户名查询条件方法.
     *
     * @param Builder $query 查询对象
     * @param string  $name  用户名
     *
     * @return Builder 查询对象
     *
     * @author Seven Du <shiweidu@outlook.com>
     * @homepage http://medz.cn
     */
    public function scopeByName(Builder $query, string $name): Builder
    {
        return $query->where('name', $name);
    }

    /**
     * Create user ppassword.
     *
     * @param string $password user password
     *
     * @return self
     *
     * @author Seven Du <shiweidu@outlook.com>
     * @homepage http://medz.cn
     */
    public function createPassword(string $password): self
    {
        $this->password = app('hash')->make($password);

        return $this;
    }

    /**
     * 验证用户密码
     *
     * @Author   Wayne[qiaobin@zhiyicx.com]
     * @DateTime 2016-12-30T18:44:40+0800
     *
     * @param string $password [description]
     *
     * @return bool 验证结果true or false
     */
    public function verifyPassword(string $password): bool
    {
        return app('hash')->check($password, $this->password);
    }

    /**
     * 用户登录记录关系.
     *
     * @Author   Wayne[qiaobin@zhiyicx.com]
     * @DateTime 2016-12-30T18:47:51+0800
     *
     * @return object \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loginRecords()
    {
        return $this->hasMany(loginRecord::class, 'user_id');
    }

    /**
     * 用户tokens关系.
     *
     * @Author   Wayne[qiaobin@zhiyicx.com]
     * @DateTime 2017-01-03T10:13:06+0800
     *
     * @return object \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tokens()
    {
        return $this->hasMany(AuthToken::class, 'user_id');
    }
}
