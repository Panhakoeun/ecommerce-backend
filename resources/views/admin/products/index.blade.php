@extends('admin.layout')

@section('title', 'Products')

@section('content')
    <div class="topline">
        <div>
            <h1>Products</h1>
            <p>Create and manage products.</p>
        </div>
        <a class="button primary" href="{{ route('admin.products.create') }}">
            <span class="icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14"></path><path d="M5 12h14"></path></svg></span>
            <span>New Product</span>
        </a>
    </div>

    <section class="panel">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>
                            @if ($product->image_url)
                                <img class="thumb" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                            @else
                                <div class="thumb thumb-empty">No image</div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $product->name }}</strong>
                        </td>
                        <td>{{ $product->category?->name ?? '-' }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            <div class="actions">
                                <a class="button" href="{{ route('admin.products.edit', $product) }}">
                                    <span class="icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 20h4l11-11-4-4L4 16v4Z"></path><path d="M13 7l4 4"></path></svg></span>
                                    <span>Edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="danger" type="submit" onclick="return confirm('Delete this product?')">
                                        <span class="icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16"></path><path d="M10 11v6"></path><path d="M14 11v6"></path><path d="M6 7l1 13h10l1-13"></path><path d="M9 7V4h6v3"></path></svg></span>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="empty">No products yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $products->links() }}</div>
    </section>
@endsection
