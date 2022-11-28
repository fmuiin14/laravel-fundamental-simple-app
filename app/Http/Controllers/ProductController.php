<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create() {
        return view('products.create');
    }

    public function edit($id) {
        $products = Product::findOrFail($id);
        return view('products.edit', compact('products'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

            $image_path = '';
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
            'image' => $image_path
        ]);

        return redirect()->route('products.index')->with('success', 'Data Berhasil Disimpan!');
    }

    public function update (Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        $products = Product::findOrFail($id);

        $products->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'slug' => Str::slug($request->name)
        ]);

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('products', 'public');

            //delete old image
            Storage::delete('public/'.$products->image);

            $products->update([
                'image'     => $image_path
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Data Berhasil Diupdate!');

    }

    public function destroy($id)
    {
        $item = Product::findOrFail($id);
        Storage::delete('public/'.$item->image);
        $item->delete();

        return redirect()->route('products.index')->with('success', 'Data Berhasil Dihapus!');
    }
}
