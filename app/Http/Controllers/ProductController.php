<?php

namespace App\Http\Controllers;

use App\DataTables\ProductsDataTable;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(ProductsDataTable $dataTable)
    {
        return $dataTable->render('admin.products.index');
    }
    public function create(){
        $categories=Category::all();
        return view('admin.products.create',['categories'=>$categories]);
    }

    public function store(Request $request){
            $request->validate([
                'title'=>'required|min:2|max:30',
                'description'=>'required|min:2|max:30',
                'quantity'=>'required|min:2|max:30',
                'price'=>'required|min:2|max:30',
                'discount_price'=>'',
                'category_id '=>'required',

            ]);
            $category = Category::where('id',$request->category_id)->first();
            if($category){
                $category->name=$request->name;
                $category->save();
            return [
                'category'=> $category,
                'status'=>true,
                'message'=>'updated successfuly'
        ];
    }}
    public function edit($id){
        $category = Category::where('id',$id)->first();
        if($category){
            return $category;
        }else{
            return abort(404);
        }
    }
    public function update(Request $request,$id){
        $request->validate([
            'name'=>'required|min:2|max:30'
        ]);
        $category = Category::where('id',$id)->first();
        if($category){
            $category->name=$request->name;
        $category->save();
        return [
            'category'=> $category,
            'status'=>200,
            'message'=>'updated successfuly'
    ];
        }else{
            return abort(404);
        }

    }
    public function delete($id)
    {

        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json([
            'status'=>true,
            'message'=> 'deleted successfully'
        ]);
    }
}
