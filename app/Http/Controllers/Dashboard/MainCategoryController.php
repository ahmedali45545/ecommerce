<?php

namespace App\Http\Controllers\Dashboard;

use DB;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;

class MainCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('_parent')->orderBy('id','DESC')-> paginate(10);
        return view('dashboard.categories.index', ['categories'=>$categories]);
    }

    public function create()
    {
         $categories =   Category::select('id','parent_id')->get();
        return view('dashboard.categories.create',['categories'=>$categories]);
    }

    public function store(MainCategoryRequest $request)
    {

        

            //validation

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            //if user choose main category then we must remove paret id from the request

            if($request -> type == 1) //main category
            {
                $request->request->add(['parent_id' => null]);
            }

            //if he choose child category we mus t add parent id


            $category = Category::create($request->except('_token'));

            //save translations
            $category->name = $request->name;
            $category->save();

            return redirect()->route('main_categories.index')->with(['success' => 'تم ألاضافة بنجاح']);
            

        

    }


    public function edit($id)
    {

        //get specific categories and its translations
        $category = Category::orderBy('id', 'DESC')->find($id);

        if (!$category)
            return redirect()->route('main_categories.index')->with(['error' => 'هذا القسم غير موجود ']);

        return view('dashboard.categories.edit', ['category'=>$category]);

    }


    public function update($id,MainCategoryRequest $request)
    {
        try {
            //validation

            //update DB


            $category = Category::orderBy('id','DESC')->find($id);

            if (!$category)
                return redirect()->route('main_categories.index')->with(['error' => 'هذا القسم غير موجود']);

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category->update($request->all());

            //save translations
            $category->name = $request->name;
            $category->save();

            return redirect()->route('main_categories.index')->with(['success' => 'تم ألتحديث بنجاح']);
        } catch (\Exception $ex) {

            return redirect()->route('main_categories.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {

        try {
            //get specific categories and its translations
            $category = Category::orderBy('id', 'DESC')->find($id);

            if (!$category)
                return redirect()->route('main_categories.index')->with(['error' => 'هذا القسم غير موجود ']);

            $category->delete();

            return redirect()->route('main_categories.index')->with(['success' => 'تم  الحذف بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('main_categories.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }
}
