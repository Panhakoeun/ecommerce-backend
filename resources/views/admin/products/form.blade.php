@csrf

<div class="form-grid">
    <div>
        <label for="category_id">Category</label>
        <select id="category_id" name="category_id" required>
            <option value="">Select category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label for="name">Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $product->name ?? '') }}" required>
        @error('name') <div class="error">{{ $message }}</div> @enderror
    </div>
</div>

<div>
    <label for="image">Image URL or Path</label>
    <input id="image" name="image" type="text" value="{{ old('image', $product->image ?? '') }}" placeholder="https://example.com/image.jpg">
    @error('image') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="upload-grid">
    <div>
        <label for="product_image">Choose Image</label>
        <input id="product_image" name="product_image" type="file" accept="image/*">
        <p class="hint">Upload JPG, PNG, GIF, or WebP. Max size: 2MB. Uploaded image replaces the URL/path.</p>
        @error('product_image') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="image-preview">
        @if (($product ?? null)?->image_url)
            <img id="product_preview" src="{{ $product->image_url }}" alt="{{ $product->name }}">
        @else
            <div id="product_preview_empty">No image selected</div>
            <img id="product_preview" src="" alt="" hidden>
        @endif
    </div>
</div>

<div>
    <label for="description">Description</label>
    <textarea id="description" name="description">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="form-grid">
    <div>
        <label for="price">Price</label>
        <input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $product->price ?? '') }}" required>
        @error('price') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label for="stock">Stock</label>
        <input id="stock" name="stock" type="number" min="0" step="1" value="{{ old('stock', $product->stock ?? 0) }}" required>
        @error('stock') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label for="low_stock_threshold">Low Stock Threshold</label>
        <input id="low_stock_threshold" name="low_stock_threshold" type="number" min="0" step="1" value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 10) }}" required>
        @error('low_stock_threshold') <div class="error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="actions">
    <a class="button" href="{{ route('admin.products.index') }}">Cancel</a>
    <button class="primary" type="submit">{{ $buttonText }}</button>
</div>

<script>
    document.getElementById('product_image')?.addEventListener('change', function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById('product_preview');
        const empty = document.getElementById('product_preview_empty');

        if (!file || !preview) {
            return;
        }

        preview.src = URL.createObjectURL(file);
        preview.hidden = false;

        if (empty) {
            empty.hidden = true;
        }
    });
</script>
