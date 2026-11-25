<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query()->orderBy('title')->get();

        return view('Admin.index', compact('products'));
    }

    public function create()
    {
        return view('Admin.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(photoRequired: true));

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->storePhoto($request);
        }

        Product::create($data);

        return redirect('/admin')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('Admin.edite', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate($this->rules());

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->storePhoto($request);
        }

        $product->update($data);

        return redirect('/admin')
            ->with('success', 'Product berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect('/admin')->with('success', 'Product deleted successfully.');
    }

    /** @return array<string, array<int, string>> */
    private function rules(bool $photoRequired = false): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'menu' => ['required', 'string', 'max:100'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['required', 'string'],
            'photo' => [$photoRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    private function storePhoto(Request $request): string
    {
        $file = $request->file('photo');
        $photoName = uniqid('product-', true).'.'.$file->extension();
        $uploadDirectory = public_path('uploads');

        File::ensureDirectoryExists($uploadDirectory);
        $file->move($uploadDirectory, $photoName);

        return $photoName;
    }
}
