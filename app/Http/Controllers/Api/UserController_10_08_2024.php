<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\UserModel;
use App\Models\User\MasterUserModel;
use App\Models\Role\Role;
use Illuminate\Support\Facades\Hash;

/**
 * Description of SurveyOnDetails
 *
 * @author user-98-pc
 */
class UserController  {

   

    public function getUserData(Request $request)
    {
        $postData = $request->all();
        if(!empty($postData['email'])){
            $email = $postData['email'];
            $res = UserModel::select('id','user_name','email','active')->where('user_name', $email)->where('fl_archive', 'N')->get()->toArray();
            if(!empty($res)){
                return response()->json(['status' => true, "data" => $res[0],'message' => 'User fetched successfully']);
            }else{
                return response()->json(['status' => false, 'message' => 'Invalid email']);
            }
        }else{
            return response()->json(['status' => false, 'message' => '{email} is required'], 403);
        }
    }
    public function createUser(Request $request)
    {
        $postData = $request->all();
        if(!empty($postData['name']) && !empty($postData['email'])){
            $role = Role::where('name', 'manager')->get()->toArray();
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d', strtotime('+1 year'));
            
            if(!empty($role)){
                $existUser = UserModel::where('user_name', $postData['email'])->get()->toArray();
                if(!empty($existUser)){
                    return response()->json(['status' => false, 'message' => 'Email is already exists.']);
                }else{
                    $roleId = $role[0]['id'];
                    $insertArr = array(
                        "user_name" => $postData['email'],
                        "role_id" => $roleId,
                        "active" => true,
                        "start_date" => $start_date,
                        "end_date" => $end_date,
                        "password" => Hash::make('123456')
                    );
                    MasterUserModel::insert([
                        "name" => $postData['name'],
                        "email" => $postData['email'],
                        "assigned" => true,
                    ]);
                    UserModel::insert($insertArr);
                    return response()->json(['status' => true, 'message' => 'User created successfully']);
                }
            }else{
                return response()->json(['status' => false, 'message' => 'Requested role not found, please contact to administrator.'], 500);
            }
        }else{
            return response()->json(['status' => false, 'message' => '{name} and {email} both is required'], 403);
        }
        return response()->json(['data' => 'success']);
    }
    public function updateStatus(Request $request)
    {
        $postData = $request->all();
        if(!empty($postData['email']) && isset($postData['active'])){
            UserModel::where('user_name',$postData['email'])->update(['active' => $postData['active']]);
            return response()->json(['status' => true, 'message' => 'User status has been changed successfully']);
        }else{
            return response()->json(['status' => false, 'message' => '{email} and {active} both is required'], 403);
        }
    }
}