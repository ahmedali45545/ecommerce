<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;
use App\Models\Brand;
use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStockRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id','DESC')->select('id','slug','price', 'created_at')->paginate(10);
        return view('dashboard.products.general.index', ['products'=>$products]);
    }
    public function create()
    {
        $data =[];
        $data['brands']=Brand::active()->select('id')->get();
        $data['tags']=Tag::active()->select('id')->get();
        $data['categories']=Category::active()->select('id')->get();
       
        return view('dashboard.products.general.create', $data);
    }

    public function store(Request $request)
    {
        

        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => 1]);

        $product = Product::create([
            'slug' => $request->slug,
            'brand_id' => $request->brand_id,
            'is_active' => $request->is_active,
        ]);
        //save translations
        $product->name = $request->name;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->save();

        //save product categories

        $product->categories()->attach($request->categories);

        //save product tags

        return redirect()->route('products.index')->with(['success' => 'تم ألاضافة بنجاح']);


    }
    public function getPrice($product_id)
    {
        return view('dashboard.products.prices.create') -> with('id',$product_id) ;
    }
    public function storePrice(Request $request)
    {
        Product::whereId($request -> product_id) -> update($request -> only(['price','special_price','special_price_type','special_price_start','special_price_end']));

        return redirect()->route('products.index')->with(['success' => 'تم التحديث بنجاح']);
    }
/////////////////////////stock //////////////
    public function getStock($product_id){

        return view('dashboard.products.stock.create') -> with('id',$product_id) ;
    }

    public function storeStock (ProductStockRequest $request){


            Product::whereId($request -> product_id) -> update($request -> except(['_token','product_id']));

            return redirect()->route('products.index')->with(['success' => 'تم التحديث بنجاح']);

    }
    public function getImages($id)
    {
        $product = Product::find($id);
        return view('dashboard.products.images.create',['product'=>$product]) -> with('id',$id) ;
    }

    //to save images to folder only
    public function storeImages(Request $request){

        $file = $request->file('dzfile');
        $fileName = saveImage($file,'assets/images/products');
        //$filename = uploadImage('products', $file);

        return response()->json([
            'name' => $fileName,
            'original_name' => $file->getClientOriginalName(),
        ]);

    }

    public function storeImagesDB(Request $request){

        //ProductImagesRequest
        // save dropzone images
        if ($request->has('document') && count($request->document) > 0) {
            foreach ($request->document as $image) {
                Image::create([
                    'product_id' => $request->product_id,
                    'photo' => $image,
                ]);
            }
        }

        return redirect()->route('products.index')->with(['success' => 'تم التحديث بنجاح']);

        
    }
}
