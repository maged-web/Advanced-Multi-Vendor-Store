<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CatergoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $request=request();

    
        $categories=Category::with('parent')->
        /*select('categories.*)
        ->selectRaw('(select count (*) from products where category_id=categories.id) as product_count')
        ->select(DB::raw('(select count (*) from products where category_id=categories.id) as product_count')))
        /* ::leftJoin('categories as parents','parents.id','=','categories.parent_id')
        ->select([
            'categories.*',
            'parents.name as parent_name'
        ])-> */
        withCount(['products as products_number'=>function($query)
        {
            $query->where('status','=','active');
        }])->
        filter($request->query())->orderBy('categories.name')->paginate(2);

        return view('dashboard.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $parents=Category::all();
        $category=new Category();
        return View('dashboard.categories.create',compact('category','parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(Category::rules());
            $request->merge(
                [
                    'slug'=>Str::slug($request->name)
                ]
                );

            $data=$request->except('image');
            $data['image']=$this->uploadImage($request);
            
       

        $category=Category::create($data);
        return Redirect::route('dashboard.categories.index')->with('success','Category created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category){

        return view('dashboard.categories.show',[
            'category'=>$category
        ]);
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try{
        $category=Category::findOrFail($id);
        }catch (Exception $e)
        {
            return Redirect::route('dashboard.categories.index')->with('info','Record not found!');

        }
        $parents=Category::where('id','<>',$id)
        ->where(function($query) use($id)
        {
            $query->whereNull('parent_id')
            ->orWhere('parent_id','<>',$id);
        })->get();

        return View('dashboard.categories.edit',compact('category','parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CatergoryRequest $request, $id)
    {
        $category=Category::find($id);
        $oldImage=$category->image;
        $data=$request->except('image');

        
          $newImage=$this->uploadImage($request);
          if($newImage)
          {
            $data['image']=$newImage;
          }
        
        $category->update($data);
        if($oldImage&&$newImage)
        {
            Storage::disk('public')->delete($oldImage);
        }
        return Redirect()->route('dashboard.categories.index')->with('success','Category updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        //$category=Category::findOrFail($id);
        $category->delete();

       /*  if($category->image)
        {
            Storage::disk('public')->delete($category->image);

        } */
        return Redirect::route('dashboard.categories.index')->with('success','Category deleted!');

    }
    public function trash()
    {
        $categories=Category::onlyTrashed()->paginate(2);
        
        return view('dashboard.categories.trashed',compact('categories'));
    }
    public function restore($id)
    {
        $category=Category::onlyTrashed()->findOrFail($id)->restore();
        return Redirect::route('dashboard.categories.trash')->with('success','Category restored!');
    }
    public function forceDelete($id)
    {
        $category=Category::onlyTrashed()->findOrFail($id)->forceDelete();
         if($category->image)
        {
            Storage::disk('public')->delete($category->image);

        }
        return Redirect::route('dashboard.categories.trash')->with('success','Category deleted forever!');
    }
    public function uploadImage(Request $request)
    {
        if(!$request->hasFile('image'))
            return;
       
        $file=$request->file('image');
        $path=$file->store('uploads','public');
        return $path;

    }
}

