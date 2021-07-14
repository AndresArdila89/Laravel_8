<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Redirect;

class BrandController extends Controller
{
    /**
     * Gets all the brands from the brands table
     * and display them on a new view
     * 
     * @return view brand view
     */
    public function AllBrand()
    {
        $brands = Brand::latest()->paginate(5);
        return view('admin.brand.index', compact('brands') );
    }

    /**
     * Edits one Brand 
     * 
     * @param string $id of the brand
     * 
     * @return view renders the edit brand page
     */
    public function Edit($id)
    {
        $brands = Brand::find($id);
        return view('admin.brand.edit', compact('brands'));

    }

    /**
     * Add a Brand to the database
     * 
     * @param Request
     * 
     * @return RedirectResponse
     */
    public function AddBrand(Request $request)
    {
        $validateData = $request->validate(
        [
            'brand_name'    => 'required|unique:brands|max:255',
            'brand_image'   => 'required|mimes:jpg,jpeg,png',
        ],
        [
            'brand_name.required'   => 'Please Input Brand Name',
            'brand_name.max'        => 'Brand must be less than 255 Character', 
            'brand_image.required'  => 'Please Upload an Image',
        ]);


        // store image process
        $brand_image  = $request->file('brand_image');

        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $img_name = $name_gen.'.'.$img_ext;
        $up_location = 'image/brand/';
        $last_img = $up_location.$img_name;
        $brand_image->move($up_location,$img_name);

        $brand = new Brand;
        $brand->brand_name = $request->brand_name;
        $brand->brand_image = $last_img;
        $brand->save();

        return Redirect()->back()->with('success','Brand Successfully Added');
    }

    /**
     * SoftDelete 
     * 
     * @param string $id Brand id
     */
    public function Delete($id)
    {
        $brand = Brand::find($id);
        unlink($brand->brand_image);
        $brand->delete();

        return Redirect()->back()->with('success', 'Brand Deleted Successfully');
    }


    /**
     * Update Brand 
     * 
     * @param string $id Brand id
     * 
     * @return RedirectResponse go back to the brands page
     */
    public function Update(Request $request, $id){
        
        $validateData = $request->validate(
        [
            'brand_name'    => 'min:4',
            'brand_image'   => 'mimes:jpg,jpeg,png',
        ],
        [
            'brand_name.min'        => 'Brand must be at least 4 Characters long', 
        ]);

        $old_image = $request->old_image;
        $brand_image = $request->file('brand_image');
        if($brand_image){
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($brand_image->getClientOriginalExtension());
            $img_name = $name_gen.'.'.$img_ext;
            $up_location = 'image/brand/';
            $last_img = $up_location.$img_name;
            $brand_image->move($up_location,$img_name);

            unlink($old_image);


            $brand = Brand::find($id);
            $brand->brand_name = $request->brand_name;
            $brand->brand_image = $last_img;
            $brand->save();
        }
        else 
        {
            $brand = Brand::find($id);
            $brand->brand_name = $request->brand_name;
            $brand->save();
        }

        return Redirect()->back()->with('success','Brand Updated Successfully');
    }




}
