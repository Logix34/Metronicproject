<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubcategoriesController extends Controller
{

    public function index()
    {
        $categories=Category::all();
        $subcategories=SubCategory::with('category')->get();
       return view('Subcategories.index',compact('subcategories','categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'banner_image' => 'required',
            'square_image' => 'required',
        ]);
        try {
            if ($request->hasFile('banner_image')) {
                $file = $request->file('banner_image');
                $extention = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extention;
                $banner_image= $file->move('uploads/Sub_Categories/banner_images/' , $filename);

            }
            if ($request->hasFile('square_image')) {
                $file = $request->file('square_image');
                $extention = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extention;
                $square_image= $file->move('uploads/Sub_Categories/square_images/' , $filename);

            }

                SubCategory::create([
                    'name'=> $request['name'],
                    'category_id'=> $request['category_id'],
                    'banner_image'=> $banner_image,
                    'square_image' => $square_image,
                ]);
                Session::flash('success','Sub Category Create Successfully');
                return redirect('sub_categories');
        }catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage() .' '.$exception->getLine());

        }
    }
    public function edit($id){
        return SubCategory::whereId($id)->first();
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',

        ]);
        try {
            $subcategory=SubCategory::whereId($request['id'])->first();
            $banner_image=$subcategory->banner_image;
            $square_image=$subcategory->square_image;

            if ($request->hasFile('banner_image')) {
                $file = $request->file('banner_image');
                $extention = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extention;
                $banner_image= $file->move('uploads/banner_images/' , $filename);

            }
            if ($request->hasFile('square_image')) {
                $file = $request->file('square_image');
                $extention = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extention;
                $square_image= $file->move('uploads/square_images/' , $filename);
            }
            $subcategory->update([
                'name'=> $request['name'],
                'category_id'=> $request['category_id'],
                'banner_image'=> $banner_image,
                'square_image' => $square_image,
            ]);
            Session::flash('success','Sub Category update Successfully');
            return redirect('sub_categories');

        }catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage() .' '.$exception->getLine());
        }
    }
    public function destroy($id)
    {
        SubCategory::whereId($id)->delete();
        Session::flash("success","record deleted successfully");
        return redirect('sub_categories');
    }
}
