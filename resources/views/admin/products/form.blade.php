@csrf

<div class="form-grid-half">
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
        <label for="name">Product Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $product->name ?? '') }}" placeholder="e.g. Cola Energy Drink" required>
        @error('name') <div class="error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-grid-half">
    <div>
        <label for="price">Price (USD $)</label>
        <div class="input-prefix-wrap">
            <span class="input-prefix">$</span>
            <input id="price" name="price" type="number" min="0" step="0.01"
                   value="{{ old('price', $product->price ?? '') }}"
                   placeholder="0.00" required
                   class="has-prefix">
        </div>
        <p class="hint">Enter the selling price in US dollars (e.g. 9.99)</p>
        @error('price') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label for="stock">Stock Quantity</label>
        <input id="stock" name="stock" type="number" min="0" step="1"
               value="{{ old('stock', $product->stock ?? 0) }}"
               placeholder="0" required>
        <p class="hint">Number of units available for purchase</p>
        @error('stock') <div class="error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-grid-half" style="grid-template-columns: 1fr 1fr 1fr;">
    <div>
        <label for="price_s">Size S Price <span class="label-optional">(optional)</span></label>
        <div class="input-prefix-wrap">
            <span class="input-prefix">$</span>
            <input id="price_s" name="price_s" type="number" min="0" step="0.01"
                   value="{{ old('price_s', $product->price_s ?? '') }}"
                   placeholder="0.00"
                   class="has-prefix">
        </div>
        @error('price_s') <div class="error">{{ $message }}</div> @enderror
    </div>
    <div>
        <label for="price_m">Size M Price <span class="label-optional">(optional)</span></label>
        <div class="input-prefix-wrap">
            <span class="input-prefix">$</span>
            <input id="price_m" name="price_m" type="number" min="0" step="0.01"
                   value="{{ old('price_m', $product->price_m ?? '') }}"
                   placeholder="0.00"
                   class="has-prefix">
        </div>
        @error('price_m') <div class="error">{{ $message }}</div> @enderror
    </div>
    <div>
        <label for="price_l">Size L Price <span class="label-optional">(optional)</span></label>
        <div class="input-prefix-wrap">
            <span class="input-prefix">$</span>
            <input id="price_l" name="price_l" type="number" min="0" step="0.01"
                   value="{{ old('price_l', $product->price_l ?? '') }}"
                   placeholder="0.00"
                   class="has-prefix">
        </div>
        @error('price_l') <div class="error">{{ $message }}</div> @enderror
    </div>
</div>

<div>
    <label for="image">Image URL or Path <span class="label-optional">(optional)</span></label>
    <input id="image" name="image" type="text" value="{{ old('image', $product->image ?? '') }}" placeholder="https://example.com/image.jpg">
    @error('image') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="upload-grid">
    <div>
        <label for="product_image">Upload Image File <span class="label-optional">(optional — overrides URL above)</span></label>
        <input id="product_image" name="product_image" type="file" accept="image/*">
        <p class="hint">JPG, PNG, GIF, or WebP. Max 2 MB.</p>
        @error('product_image') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="image-preview">
        @if (($product ?? null)?->image_url)
            <img id="product_preview" src="{{ $product->image_url }}" alt="{{ $product->name ?? '' }}">
        @else
            <div id="product_preview_empty">No image selected</div>
            <img id="product_preview" src="" alt="" hidden>
        @endif
    </div>
</div>

<div>
    <label for="description">Description <span class="label-optional">(optional)</span></label>
    <textarea id="description" name="description" placeholder="Describe the product — ingredients, usage, highlights…">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description') <div class="error">{{ $message }}</div> @enderror
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

        if (!file || !preview) return;

        preview.src = URL.createObjectURL(file);
        preview.hidden = false;

        if (empty) empty.hidden = true;
    });
</script>
