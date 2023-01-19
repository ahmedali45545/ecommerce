<?php

namespace App\Http\Controllers\Dashboard;

use DB;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;

class SubCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::child()->orderBy('id','DESC') -> paginate(10);
        return view('dashboard.subcategories.index',['categories'=>$categories]);
    }

    public function create()
    {
        $categories = Category::parent()->orderBy('id','DESC') -> get();
        return view('dashboard.subcategories.create',['categories'=>$categories]);
    }


    public function store(SubCategoryRequest $request)
    {
        

        try {

            //validation

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category = Category::create($request->except('_token'));

            //save translations
            $category->name = $request->name;
            $category->save();

            return redirect()->route('sub_categories.index')->with(['success' => 'تم ألاضافة بنجاح']);
           

        } catch (\Exception $ex) {
            
            return redirect()->route('sub_categories.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function edit($id)
    {


        //get specific categories and its translations
        $category = Category::orderBy('id', 'DESC')->find($id);

        if (!$category)
            return redirect()->route('sub_categories.index')->with(['error' => 'هذا القسم غير موجود ']);

        $categories = Category::parent()->orderBy('id','DESC') -> get();


        return view('dashboard.subcategories.edit',['categories'=>$categories,'category'=>$category]);

    }


    public function update($id, SubCategoryRequest $request)
    {
        try {
            //validation

            //update DB


            $category = Category::find($id);

            if (!$category)
                return redirect()->route('sub_categories.index')->with(['error' => 'هذا القسم غير موجود']);

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category->update($request->all());

            //save translations
            $category->name = $request->name;
            $category->save();

            return redirect()->route('sub_categories.index')->with(['success' => 'تم ألتحديث بنجاح']);
        } catch (\Exception $ex) {

            return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {

        try {
            //get specific categories and its translations
            $category = Category::orderBy('id', 'DESC')->find($id);

            if (!$category)
                return redirect()->route('sub_categories.index')->with(['error' => 'هذا القسم غير موجود ']);

            $category->delete();

            return redirect()->route('sub_categories.index')->with(['success' => 'تم  الحذف بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('sub_categories.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

}
