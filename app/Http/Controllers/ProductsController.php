<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\FAcades\Storage;
use App\Product;

class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$products = Product::all();
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        return view('products.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
            'details' => 'required',
            'price' => 'required',
            'cover_image' => 'image|nullable|max:1999',
        ]);

        //handle file upload
        if($request->hasFile('cover_image')){
            //get filename with extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_image', $fileNameToStore);
        } else{
            $fileNameToStore = 'noimage.jpg';
        }
        
        //add product
        $product = new Product;
        $product->name = $request->input('name');
        $product->type = $request->input('type');
        $product->details = $request->input('details');
        $product->price = $request->input('price');
        $product->user_id = auth()->user()->id;
        $product->cover_image = $fileNameToStore;
        $product->save(); 

        return redirect('/products')->with('success', 'Products Added');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return view('products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $product = Product::find($id);

        //check for correct user
        if(auth()->user()->id !==$product->user_id){
            return redirect('/products')->with('error', 'Unauthorized Page'); 
        }

        return view('products.edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
            'details' => 'required',
            'price' => 'required',
        ]);

        //handle file upload
        if($request->hasFile('cover_image')){
            //get filename with extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_image', $fileNameToStore);
        } 
        
        //add product
        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->type = $request->input('type');
        $product->details = $request->input('details');
        $product->price = $request->input('price');
        if($request->hasFile('cover_image')){
            $product->cover_image =$fileNameToStore;
        }
        $product->save();

        return redirect('/products')->with('success', 'Product Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        //check for correct user
        if(auth()->user()->id !==$product->user_id){
            return redirect('/products')->with('error', 'Unauthorized Page'); 
        }

        if($product->cover_image != 'noimage.jpg'){
            //delete image
            Storage::delete('public/cover_images/'.$product->cover_image);
        }

        $product->delete();
        return redirect('/products')->with('success', 'Product removed');
    }
}
