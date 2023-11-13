<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::select('id', 'name')->get();

        if ($request->ajax()) {
            return DataTables::of($categories)
                ->addColumn('actions', function ($row) {
                    return '<a href="javascript:void(0)" class="btn btn-info edit_btn" data-id="' . $row->id . '">Edit</a><a href="javascript:void(0)" class="btn btn-danger delete_btn" data-id="' . $row->id . '">Delete</a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.categories.index', compact("categories"));
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
                'status'=>200,
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
            'status'=>200,
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

}
