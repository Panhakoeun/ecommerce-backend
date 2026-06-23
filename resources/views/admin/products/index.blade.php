@extends('admin.layout')

@section('title', 'Products')

@section('content')
<style>
    .actions { justify-content: center !important; align-items: center; }
    th:last-child, td:last-child { text-align: center !important; }
    .actions form { display: flex; margin: 0; }
</style>
    <div class="topline">
        <div>
            <h1>Products {{ request('stock_status') === 'low' ? '(Low Stock)' : '' }}</h1>
            <p>Create and manage products.</p>
            @if(request('stock_status'))
                <p style="margin-top: 4px;"><a href="{{ route('admin.products.index') }}" style="color: var(--accent); font-weight: bold; text-decoration: underline;">&larr; Show all products</a></p>
            @endif
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
                    <th>Actions</th>
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
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span>{{ $product->stock }}</span>
                                @if($product->stock <= $product->low_stock_threshold)
                                    <span class="badge" style="padding: 2px 6px; font-size: 10px; background: {{ $product->stock <= 0 ? '#fee2e2' : '#fef3c7' }}; color: {{ $product->stock <= 0 ? '#b91c1c' : '#92400e' }};">
                                        {{ $product->stock <= 0 ? 'Out' : 'Low' }}
                                    </span>
                                @endif
                            </div>
                        </td>
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
