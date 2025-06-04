

<div class="container py-5 custom-container">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="profile-card">
        <div class="profile-header">
          <h2>Update Password</h2>
        </div>
        <div class="px-4">
          <form method="post" action="{{ route('password.update') }}" class="mt-4">
            @csrf
            @method('put')

            <!-- Current Password -->
            <div class="mb-3">
              <label for="update_password_current_password" class="form-label">Password Saat Ini</label>
              <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" required>
              <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <!-- New Password -->
            <div class="mb-3">
              <label for="update_password_password" class="form-label">Password Baru</label>
              <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" required>
              <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
              <label for="update_password_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
              <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" required>
              <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="text-center mt-4">
              <button type="submit" class="btn btn-save">Simpan Password</button>

              @if (session('status') === 'password-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="mt-2 text-sm text-success">
                  Password berhasil diperbarui.
                </p>
              @endif
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
