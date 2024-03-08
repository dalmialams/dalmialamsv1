<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Mail;

class SendMailModel extends BaseModel {

    public function __construct() {
        parent:: __construct();
    }

    public function sendWelcomeEmail($user_id, $new_password) {
        $user = User\UserModel::where(['id' => $user_id])->get()->toArray();
        $this->data['user'] = isset($user[0]) ? $user[0] : '';
        $this->data['password'] = $new_password;
        Mail::send('admin.emails.welcome', $this->data, function ($m) use ($user) {
            $email = $this->data['user']['user_name'];
            $m->from('admin@landmgmt.dalmiabharat.com', 'Dalmia Lams');
            $m->to($email, '')->subject('Welcome to Dalmia::Lams!');
        });
    }

    public function sendForgotPasswordEmail($user_id, $link) {
        $user = User\UserModel::where(['id' => $user_id])->get()->toArray();
        
        $this->data['user'] = isset($user[0]) ? $user[0] : '';
        $this->data['link'] = $link;
        //$email=$this->data['user']['user_name'];
        Mail::send('admin.emails.forgot_pwd', $this->data, function ($m) use ($user) {
            $email=$user[0]['user_name'];
            $email = ($email == 'admin') ? 'admin@dalmia.com' : $this->data['user']['user_name'];
            $m->from('souvik.cs123@gmail.com', 'Dalmia Lams');
            $m->to($email, $user[0]['user_name'])->subject('Forgot Password Link');
        });
    }

}
