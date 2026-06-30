@csrf

<div>
    <label for="name">Name</label>
    <input id="name" name="name" type="text" value="{{ old('name', $category->name ?? '') }}" required>
    @error('name') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="actions">
    <a class="button" href="{{ route('admin.categories.index') }}">Cancel</a>
    <button class="primary" type="submit">{{ $buttonText }}</button>
</div>
