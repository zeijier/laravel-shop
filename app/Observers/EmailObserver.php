<?php
namespace App\Observers;

use App\Models\User;
use App\Notifications\EmailVerificationNotification;

class EmailObserver{
// 监听用户创建完成事件，调用notify 发送通知
    public function saved(User $user){
        $user->notify(new EmailVerificationNotification());
    }
}