<div class="form-group">
    <label>Deskripsi Produk <span class="text-danger">*</span></label>

    {{-- Quill editor container --}}
    <div id="quill-editor"
         style="min-height:160px; background:#fff; border-radius:0 0 4px 4px;"
         class="{{ $errors->has('caption') ? 'border border-danger' : '' }}"></div>

    {{-- Hidden input carries value on submit --}}
    <textarea id="caption" name="caption" style="display:none"
              required>{{ old('caption', $product->caption ?? '') }}</textarea>

    @error('caption')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Gambar Produk</label>
            @if(isset($product) && $product->image)
                <div class="mb-2">
                    <img src="{{ $product->image_url }}" alt="current"
                         style="height:100px;object-fit:cover;border-radius:8px;border:1px solid #dee2e6;">
                    <br><small class="text-muted">Gambar saat ini. Upload baru untuk mengganti.</small>
                </div>
            @endif
            <div class="custom-file">
                <input type="file" id="image" name="image"
                       class="custom-file-input @error('image') is-invalid @enderror"
                       accept="image/jpeg,image/jpg,image/png,image/webp">
                <label class="custom-file-label" for="image">Pilih gambar...</label>
            </div>
            <small class="text-muted">JPEG/PNG/WebP, maks 2MB</small>
            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="sort_order">Urutan</label>
            <input type="number" id="sort_order" name="sort_order" min="0" max="9999"
                   class="form-control @error('sort_order') is-invalid @enderror"
                   value="{{ old('sort_order', $product->sort_order ?? 0) }}">
            <small class="text-muted">Angka kecil tampil lebih dulu</small>
            @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
    <div class="col-md-3">
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
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>
<script>
(function () {
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

    // Load existing value into Quill
    var existing = document.getElementById('caption').value;
    if (existing) {
        quill.clipboard.dangerouslyPasteHTML(existing);
    }

    // Sync to hidden textarea before submit
    quill.root.closest('form').addEventListener('submit', function () {
        document.getElementById('caption').value = quill.getSemanticHTML();
    });

    // Image file label
    document.getElementById('image').addEventListener('change', function () {
        var name = this.files[0] ? this.files[0].name : 'Pilih gambar...';
        this.nextElementSibling.textContent = name;
    });
})();
</script>
@endpush
