<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    public function AllCat(){
        // using ORM
        // $categories = Category::all();
        $categories = Category::latest()->paginate(5);
        $trashCategories = Category::onlyTrashed()->latest()->paginate(3);

        // using QUERY BUILDER
        // $categories = DB::table('categories')->latest()->get(); 


        /**
         *  JOIN TABLES WITH QUERY BUILDER
         *  $categories = DB::table('categories')
         *      ->join('users', 'categories.user_id', 'users.id')
         *      ->select('categories.*', 'users.name')
         *      ->latest()->paginate(3);
         */ 
        
        return view('admin.category.index', compact('categories', 'trashCategories'));
    }

    public function AddCat(Request $request ){
        $validateData = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ],
        [
            'category_name.required' => 'Please Input Category Name',
            'category_name.max' => 'Category must be less than 255 Characters',
        ]);
        
        // Category::insert([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id,
        //     'created_at' => Carbon::now()
        // ]);


        // Best practice Eloquent ORM
        $category = new Category;
        $category->category_name = $request->category_name;
        $category->user_id = Auth::user()->id;
        $category->save();

        // Query builder
        // $data = array();
        // $date['category_name'] = $request->category_name;
        // $date['user_id'] = $request->user_id;
        // DB::table('categories')->insert($data);

        return Redirect()->back()->with('success','Category Inserted Successfull');
    }

    public function Edit($id){
        $categories = Category::find($id);

        return view('admin.category.edit',compact('categories'));
    }

    public function Update(Request $request , $id){
        $update = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
        ]);

        // QUERY BUILDER 
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->where('id',$id)->update($data);

        return Redirect()->route('all.category')->with('success','Category Successfully Updated'); 
    }

    public function SoftDelete($id)
    {
        $delete = Category::find($id)->delete();
        return Redirect()->back()->with('success', 'Category Successfully Deleted');
    }

    public function Restore($id)
    {
        $delete = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success','Category Successfully Restored');
    }

    public function PermanentDelete($id){
        $delete = Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('success','Category Deleted Permanently');
    }
}
