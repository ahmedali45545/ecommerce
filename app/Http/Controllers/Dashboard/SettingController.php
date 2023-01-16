<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Setting;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingsRequest;

class SettingController extends Controller
{
    



    public function editShippingMethods($type)
    {

        //free , inner , outer for shipping methods

        if ($type === 'free')
             $shippingMethod = Setting::where('key', 'free_shipping_label')->first();


        elseif ($type === 'local')
            $shippingMethod = Setting::where('key', 'local_label')->first();

        elseif ($type === 'outer')
            $shippingMethod = Setting::where('key', 'outer_label')->first();
        else
            $shippingMethod = Setting::where('key', 'free_shipping_label')->first();


        return view('dashboard.settings.shipping_methods.edit', ['shippingMethod'=>$shippingMethod]);

    }
    
    public function updateShippingMethods(ShippingsRequest $request, $id)
    {

        //validation

        //update db

        try {
            $shipping_method = Setting::find($id);

            DB::beginTransaction();
            $shipping_method->update(['plain_value' => $request->plain_value]);
            //save translations
            $shipping_method->value = $request->value;
            $shipping_method->save();

            DB::commit();
            return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'هناك خطا ما يرجي المحاولة فيما بعد']);
            DB::rollback();
        }

    }
}
