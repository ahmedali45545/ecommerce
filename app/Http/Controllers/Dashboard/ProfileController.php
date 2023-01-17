<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function editProfile()
    {
        $admin = Admin::find(auth('admin')->user()->id);

        return view('dashboard.profile.edit', ['admin'=>$admin]);
    }

    public function updateProfile(ProfileRequest $request)
    {
        try {
            $admin = Admin::find(auth('admin')->user()->id);
        
            $data = $request->except('_token','id','password','password_confirmation');

            if($request->has('password')&& !is_null($request->  password)){
                $data['password']=bcrypt($request->password);
            }
            $admin->update($data);    
            return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'هناك خطا ما يرجي المحاولة فيما بعد']);
        }
        
    }
}
