<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

// 使用者帳號資料
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'id_password';   // 資料表名稱
    protected $primaryKey = 'uid';      // 主鍵
    public $incrementing = true;
    public $timestamps = false; // 因為我們沒有設定 created_at 或 updated_at 的欄位，不需要時間戳記
    protected $fillable =
        ['uid', 'email', 'mobilephone', 'password', 'repassword'];

    public function Device()
    {
        // hasMany 多筆
        return $this->hasMany(Device::class, 'email', 'email');
    }

    public function UserData()
    {
        return $this->hasOne(UserData::class, 'email', 'email');
    }
}
