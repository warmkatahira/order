<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserStatusChangeMail;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function user_index()
    {
        // ユーザー情報を取得
        $users = User::all();
        // ロール情報を取得
        $roles = Role::all();
        return view('admin.user_index')->with([
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function user_save(Request $request)
    {
        // 情報を更新 
        for($i = 0; $i < count($request->id); $i++) {
            // 更新する対象を取得
            $user = User::find($request->id[$i]);
            $user->name = $request->name[$i];
            $user->company = $request->company[$i];
            $user->email = $request->email[$i];
            $user->role_id = $request->role_id[$i];
            $user->status = $request->status[$i];
            // statusが更新されているか判定(ステータスが変更されていて、無効から有効に変わった場合はメールを送る)
            $mail_send_flg = $user->isDirty("status") == true && $user->status == '1' ? True : False;
            $user->save();
            // フラグがTrueなら、メールを送信
            if($mail_send_flg == True){
                // メールを送信
                Mail::send(new UserStatusChangeMail($user->name, $user->email));
            }
        }
        return back();
    }
}
