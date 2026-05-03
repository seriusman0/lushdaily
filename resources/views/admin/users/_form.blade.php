<div class="form-group">
    <label for="name">Nama <span class="text-danger">*</span></label>
    <input type="text" id="name" name="name"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $user->name ?? '') }}"
           placeholder="Nama lengkap" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="email">Email <span class="text-danger">*</span></label>
    <input type="email" id="email" name="email"
           class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email', $user->email ?? '') }}"
           placeholder="email@example.com" required>
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="password">
        Password <span class="text-danger">*</span>
        @if(isset($isEdit))
            <small class="text-muted">(kosongkan jika tidak diubah)</small>
        @endif
    </label>
    <input type="password" id="password" name="password"
           class="form-control @error('password') is-invalid @enderror"
           placeholder="Min 8 karakter (huruf + angka)"
           {{ isset($isEdit) ? '' : 'required' }}>
    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="role">Role <span class="text-danger">*</span></label>
    <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" required>
        <option value="user"  {{ old('role', $user->role ?? 'user')  === 'user'  ? 'selected' : '' }}>User</option>
        <option value="admin" {{ old('role', $user->role ?? 'user') === 'admin' ? 'selected' : '' }}>Admin</option>
    </select>
    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
