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
        {
            $request->validate([
                'name' => 'required',
                'category_id' => 'required',
            ]);

            if ($request->hasFile('banner_image')) {
                $banner_image = $request->file('banner_image');
                $fileName = time() . '-' . $banner_image->getClientOriginalName();
                $banner_image->move('assets/uploads', $fileName);
                $banner_image_path = 'assets/uploads/' . $fileName;
            }
            if ($request->hasFile('square_image')) {
                $square_image = $request->file('square_image');
                $fileName = time() . '-' . $square_image->getClientOriginalName();
                $square_image->move('assets/uploads', $fileName);
                $square_image_path = 'assets/uploads/' . $fileName;
            }
            try {
                $subc = new SubCategory;
                $subc->name = $request->name;
                $subc->banner_image = isset($banner_image_path) ? $banner_image_path : null;
                $subc->square_image = isset($square_image_path) ? $square_image_path : null;


                $subc->category_id = $request->category_id;

                if ($subc->save()) {
                    return redirect()->back()->with('success', 'SubCategory Has been Created');
                } else {
                    return redirect()->back()->with('error', 'Something went wrong!');
                }


            } catch (\Exception $exception) {
                return redirect()->back()->with('error', $exception->getMessage() . ' ' . $exception->getLine());

            }
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
