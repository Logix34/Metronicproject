<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{

    public function index()
    {
        $categories=Category::all();
       return view('Categories.index',compact('categories'));
    }
    public function store(Request $request)
    {
        try {
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
                Category::create([
                    'name'=> $request['name'],
                    'banner_image'=> $banner_image,
                    'square_image' => $square_image,
                ]);
                Session::flash('success','Category Create Successfully');
                return redirect('categories');
        }catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage() .' '.$exception->getLine());
        }
    }

    public function editcategory($id){
      return Category::whereId($id)->first();
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',

        ]);
        try {
            $category=Category::whereId($request['id'])->first();
             $banner_image=$category->banner_image;
             $square_image=$category->square_image;

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
            $category->update([
                'name'=> $request['name'],
                'banner_image'=> $banner_image,
                'square_image' => $square_image,
            ]);
                Session::flash('success','Category update Successfully');
                return redirect('categories');

        }catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage() .' '.$exception->getLine());
        }
    }

    public function destroy($id)
    {
        Category::whereId($id)->delete();
        Session::flash("success","record deleted successfully");
        return redirect('categories');
    }
}

