@props(['action', 'product' => null, 'method' => 'POST', 'submitLabel' => 'Save product'])

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="product-form" data-product-form data-current-category="{{ old('category', $product?->category ?? '') }}" data-current-menu="{{ old('menu', $product?->menu ?? '') }}">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    @if($errors->any())
        <div class="notice notice-error" role="alert">
            <p>Please check the highlighted fields and try again.</p>
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="form-layout">
        <div class="form-photo-column">
            <label class="field-label" for="photo-upload">Product photograph</label>
            <label class="upload-panel" for="photo-upload">
                @if($product?->photo)
                    <img class="upload-preview" id="image-preview" src="{{ asset('uploads/' . $product->photo) }}" alt="Current product photograph">
                @else
                    <img class="upload-preview is-hidden" id="image-preview" alt="Selected product preview">
                @endif
                <span class="upload-prompt" data-upload-placeholder>
                    <span class="upload-icon" aria-hidden="true">＋</span>
                    <strong>Choose a photo</strong>
                    <span>JPG, PNG or WEBP</span>
                </span>
                <input id="photo-upload" name="photo" type="file" accept="image/*" class="visually-hidden" data-photo-input>
            </label>
            <p class="field-hint">A clear, well-lit image helps each piece shine.</p>
        </div>

        <div class="form-fields">
            <div class="field-group">
                <label class="field-label" for="title">Product name</label>
                <input id="title" name="title" type="text" value="{{ old('title', $product?->title) }}" placeholder="For example, The Bluebell Bouquet" required>
                @error('title')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-row">
                <div class="field-group">
                    <label class="field-label" for="category">Category</label>
                    <select id="category" name="category" required data-category-select>
                        <option value="">Choose a category</option>
                        @foreach(['bouquet' => 'Bouquet', 'cake' => 'Cake', 'rustic' => 'Rustic', 'mahar' => 'Mahar', 'hampers' => 'Hampers', 'designundangan' => 'Design Undangan', 'flowertable' => 'Flower Table'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('category', $product?->category) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="field-group">
                    <label class="field-label" for="menu">Collection item</label>
                    <select id="menu" name="menu" required data-menu-select>
                        <option value="">Choose a category first</option>
                    </select>
                    @error('menu')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="field-group">
                <label class="field-label" for="price">Price (IDR)</label>
                <div class="price-input"><span aria-hidden="true">Rp</span><input id="price" name="price" type="number" min="0" step="1000" value="{{ old('price', $product?->price) }}" placeholder="150000" required></div>
                @error('price')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="field-group">
                <label class="field-label" for="description">Description</label>
                <textarea id="description" name="description" rows="5" placeholder="Share what makes this piece special." required>{{ old('description', $product?->description) }}</textarea>
                @error('description')<span class="field-error">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <div class="form-actions">
        <a class="button button-quiet" href="{{ url('/admin') }}">Cancel</a>
        <button class="button" type="submit">{{ $submitLabel }} <span aria-hidden="true">→</span></button>
    </div>
</form>
