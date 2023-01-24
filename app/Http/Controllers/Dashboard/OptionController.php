<?php

namespace App\Http\Controllers\Dashboard;

use DB;
use App\Models\Option;
use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\OptionsRequest;

class OptionController extends Controller
{
    public function index()
    {
        $options = Option::with(['product' => function ($prod) {
            $prod->select('id');
        }, 'attribute' => function ($attr) {
            $attr->select('id');
        }])->select('id', 'product_id', 'attribute_id', 'price')->paginate(15);

        return view('dashboard.options.index', ['options'=>$options]);
    }

    public function create()
    {
        $data = [];
        $data['products'] = Product::active()->select('id')->get();
        $data['attributes'] = Attribute::select('id')->get();

        return view('dashboard.options.create', $data);
    }

    public function store(OptionsRequest $request)
    {


        DB::beginTransaction();

        //validation
        $option = Option::create([
            'attribute_id' => $request->attribute_id,
            'product_id' => $request->product_id,
            'price' => $request->price,
        ]);
        //save translations
        $option->name = $request->name;
        $option->save();
        DB::commit();

        return redirect()->route('options.index')->with(['success' => 'تم ألاضافة بنجاح']);
    }

    public function edit($optionId)
    {

        $data = [];
         $data['option'] = Option::find($optionId);

        if (!$data['option'])
            return redirect()->route('options.index')->with(['error' => 'هذه القيمة غير موجود ']);

        $data['products'] = Product::active()->select('id')->get();
        $data['attributes'] = Attribute::select('id')->get();

        return view('dashboard.options.edit', $data);

    }

    public function update($id, OptionsRequest $request)
    {
        try {

             $option = Option::find($id);

            if (!$option)
                return redirect()->route('options.index')->with(['error' => 'هذا ألعنصر غير موجود']);

            $option->update($request->only(['price','product_id','attribute_id']));
            //save translations
            $option->name = $request->name;
            $option->save();

            return redirect()->route('options.index')->with(['success' => 'تم ألتحديث بنجاح']);
        } catch (\Exception $ex) {

            return redirect()->route('options.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {

        
    }
}
