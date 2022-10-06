<?php

namespace App\Services;

use App\Models\User;

class MailTargetService
{
    public function getMailTargetAll()
    {
        // メールを送る対象を取得（ステータスが有効なユーザー）
        $users = User::where('status', '1')
                    ->get();
        return $users;
    }

    public function getMailTargetOrderWarehouse($not_send_id)
    {
        // メールを送る対象を取得（ステータスが有効かつ権限がシステム管理者以外のユーザー）
        $users = User::where('status', '1')
                    ->where('role_id', '!=', '1')
                    ->where('id', '!=', $not_send_id)
                    ->get();
        return $users;
    }

    public function getMailTargetWarehouse($not_send_id)
    {
        // メールを送る対象を取得（ステータスが有効かつ権限が倉庫のユーザー）
        $users = User::where('status', '1')
                    ->where('role_id', '=', '21')
                    ->where('id', '!=', $not_send_id)
                    ->get();
        return $users;
    }
}