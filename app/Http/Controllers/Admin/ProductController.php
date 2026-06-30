<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data = $this->prepareImageData($request, $data);

        Product::create($data);

        return redirect()->route('admin.products.index')->with('status', 'Product created.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validatedData($request, $product);
        $data = $this->prepareImageData($request, $data, $product);

        $product->update($data);

        return redirect()->route('admin.products.index')->with('status', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $this->deleteStoredImage($product->image);
        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Product deleted.');
    }

    private function validatedData(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'product_image' => ['nullable', 'image', 'max:2048'],
        ]);
    }

    private function prepareImageData(Request $request, array $data, ?Product $product = null): array
    {
        unset($data['product_image']);

        if ($request->hasFile('product_image')) {
            if ($product) {
                $this->deleteStoredImage($product->image);
            }

            $data['image'] = $request->file('product_image')->store('products', 'public');
        }

        return $data;
    }

    private function deleteStoredImage(?string $image): void
    {
        if (! $image || Str::startsWith($image, ['http://', 'https://', 'data:', 'storage/'])) {
            return;
        }

        Storage::disk('public')->delete($image);
    }}
