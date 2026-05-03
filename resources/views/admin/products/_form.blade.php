{{-- Name --}}
<div class="form-group">
    <label for="name">Nama Produk</label>
    <input type="text" id="name" name="name"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $product->name ?? '') }}"
           placeholder="Nama produk (opsional, jika kosong akan diambil dari deskripsi)">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

{{-- Description --}}
<div class="form-group">
    <label>Deskripsi Produk <span class="text-danger">*</span></label>
    <div id="quill-editor"
         style="min-height:160px; background:#fff;"
         class="{{ $errors->has('caption') ? 'border border-danger' : '' }}"></div>
    <textarea id="caption" name="caption" style="display:none"
              required>{{ old('caption', $product->caption ?? '') }}</textarea>
    @error('caption') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
</div>

{{-- Existing Images --}}
@if(isset($product) && $product->images->isNotEmpty())
<div class="form-group">
    <label>Gambar Saat Ini</label>
    <div class="d-flex flex-wrap gap-2" id="existing-images-grid" style="gap:0.5rem;display:flex;flex-wrap:wrap;">
        @foreach($product->images as $img)
        <div class="existing-img-item position-relative" id="img-wrapper-{{ $img->id }}"
             style="width:100px;flex-shrink:0;">
            <img src="{{ $img->url }}" alt=""
                 style="width:100px;height:100px;object-fit:cover;border-radius:8px;border:1px solid #dee2e6;">
            <button type="button"
                    class="btn btn-xs btn-danger position-absolute"
                    style="top:4px;right:4px;padding:2px 6px;line-height:1;"
                    onclick="deleteImage({{ $img->id }}, this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endforeach
    </div>
    <small class="text-muted">Klik × untuk menghapus gambar</small>
</div>
@endif

{{-- Upload New Images --}}
<div class="form-group">
    <label>
        {{ isset($product) ? 'Tambah Gambar Baru' : 'Upload Gambar' }}
        <small class="text-muted">(unlimited, JPEG/PNG/WebP, maks 3MB/gambar)</small>
    </label>
    <div class="custom-file">
        <input type="file" id="images" name="images[]"
               class="custom-file-input @error('images.*') is-invalid @enderror"
               accept="image/jpeg,image/jpg,image/png,image/webp"
               multiple>
        <label class="custom-file-label" for="images">Pilih gambar (bisa lebih dari 1)...</label>
    </div>
    @error('images.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror

    {{-- Preview grid for new uploads --}}
    <div id="preview-grid" class="mt-2 d-flex flex-wrap" style="gap:0.5rem;"></div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="sort_order">Urutan</label>
            <input type="number" id="sort_order" name="sort_order" min="0" max="9999"
                   class="form-control @error('sort_order') is-invalid @enderror"
                   value="{{ old('sort_order', $product->sort_order ?? 0) }}">
            <small class="text-muted">Angka kecil tampil lebih dulu</small>
            @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Status</label>
            <div class="custom-control custom-switch mt-2">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                       {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                <label class="custom-control-label" for="is_active">Aktif (tampil di toko)</label>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet">
<style>
    #quill-editor .ql-editor { min-height: 150px; font-size: 14px; }
    .ql-toolbar.ql-snow { border-radius: 4px 4px 0 0; border-color: #ced4da; }
    .ql-container.ql-snow { border-color: #ced4da; border-radius: 0 0 4px 4px; }
    .preview-thumb { width:80px;height:80px;object-fit:cover;border-radius:6px;border:1px solid #dee2e6; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>
<script>
(function () {
    // Quill
    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Tulis deskripsi produk di sini...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                [{ 'size': ['small', false, 'large'] }],
                ['clean']
            ]
        }
    });

    var existing = document.getElementById('caption').value;
    if (existing) quill.clipboard.dangerouslyPasteHTML(existing);

    quill.root.closest('form').addEventListener('submit', function () {
        document.getElementById('caption').value = quill.getSemanticHTML();
    });

    // Multi-image preview
    document.getElementById('images').addEventListener('change', function () {
        var grid = document.getElementById('preview-grid');
        grid.innerHTML = '';
        var label = this.nextElementSibling;
        label.textContent = this.files.length > 0
            ? this.files.length + ' gambar dipilih'
            : 'Pilih gambar (bisa lebih dari 1)...';

        Array.from(this.files).forEach(function (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var wrapper = document.createElement('div');
                wrapper.style.cssText = 'position:relative;display:inline-block;';
                var img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'preview-thumb';
                wrapper.appendChild(img);
                grid.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    });
})();

// Delete existing image via AJAX
function deleteImage(id, btn) {
    if (!confirm('Hapus gambar ini?')) return;

    fetch('/admin/product-images/' + id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    })
    .then(function (res) { return res.json(); })
    .then(function (data) {
        if (data.success) {
            document.getElementById('img-wrapper-' + id).remove();
        }
    })
    .catch(function () { alert('Gagal menghapus gambar.'); });
}
</script>
@endpush
