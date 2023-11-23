<?php

namespace App\Http\Controllers;

use App\DataTables\CategoryDataTable;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
class CategoryController extends Controller
{
    public function index(CategoryDataTable $dataTable)
    {

        return $dataTable->render('admin.categories.index');
    }

    public function store(Request $request){
        if($request->category_id){
            $request->validate([
                'name'=>'required|min:2|max:30'
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
            }else{
                return abort(404);
            }
        }else{
            $request->validate([
            'name'=>'required|min:2|max:30'
        ]);
        $category = Category::create([
            'name'=> $request->name,
        ]);
        return [
            'category'=> $category,
            'status'=>true,
            'message'=>'saved successfuly'
    ];
        }

    }
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
