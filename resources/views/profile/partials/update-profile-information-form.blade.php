
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

  :root {
    --primary-color: #ff6b8b;
    --secondary-color: #ff9a9e;
    --dark-color: #1f1f1f;
    --light-color: #f8f9fa;
  }

  body {
    font-family: 'Poppins', sans-serif;
    background-color: var(--light-color);
    color: #333;
  }

  .profile-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    padding-bottom: 30px;
  }

  .profile-header {
    background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
    padding: 20px 20px 35px;
    text-align: center;
    color: white;
    position: relative;
  }

  .profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 5px solid white;
    object-fit: cover;
    margin: -40px auto 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    background-color: #f8bbd0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    color: white;
    position: relative;
    z-index: 1;
  }

  .form-label {
    font-weight: 500;
    font-size: 14px;
  }

  .form-control {
    border-radius: 8px;
  }

  .btn-save {
    background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 10px;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 107, 139, 0.3);
  }

  .btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 139, 0.4);
    color: white;
  }

  @media (min-width: 992px) {
    .custom-container {
      max-width: 960px;
    }
  }

  @media (min-width: 1200px) {
    .custom-container {
      max-width: 1140px;
    }
  }

  @media (min-width: 1400px) {
    .custom-container {
      max-width: 1280px;
    }
  }
</style>

<div class="container py-5 custom-container">
  <div class="row justify-content-center">
    <div class="col-12">
      {{-- Alert sukses --}}
      @if (session('status') === 'profile-updated')
        <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Berhasil!</strong> Perubahan berhasil disimpan.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <div class="profile-card">
        <div class="profile-header">
          <h2 class="fw-bold">Profil Biodata</h2>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="px-4">
          @csrf
          @method('patch')

          <div class="text-center mb-3">
            <label for="profile_photo" style="cursor:pointer;">
              @if($user->profile_photo)
                <img src="{{ asset('storage/' . $user->profile_photo) }}" class="profile-avatar" alt="Foto Profil">
              @else
                <div class="profile-avatar">
                  {{ substr($user->name, 0, 1) }}
                </div>
              @endif
              <input type="file" id="profile_photo" name="profile_photo" class="d-none" accept="image/*">
            </label>
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
          </div>

          <!-- Nama -->
          <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
          </div>

          <!-- Verifikasi Email -->
          @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="mt-2 text-center">
              <p class="text-sm text-danger">
                Email kamu belum terverifikasi.
                <button form="send-verification" class="btn btn-link p-0">Kirim ulang email verifikasi</button>
              </p>
              @if (session('status') === 'verification-link-sent')
                <p class="mt-1 text-sm text-success">
                  Link verifikasi baru telah dikirim ke email kamu.
                </p>
              @endif
            </div>
          @endif

          <!-- Jenis Kelamin -->
          <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
              <option value="" disabled {{ old('jenis_kelamin', $user->jenis_kelamin ?? '') == '' ? 'selected' : '' }}>Pilih jenis kelamin</option>
              <option value="laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin ?? '') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
              <option value="perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin ?? '') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          @if ($user->role === 'mahasiswa')
            <!-- NIM -->
            <div class="mb-3">
              <label for="nim" class="form-label">NIM</label>
              <input id="nim" name="nim" type="text" class="form-control" value="{{ old('nim', $user->nim) }}">
              <x-input-error class="mt-2" :messages="$errors->get('nim')" />
            </div>

            <!-- Jurusan -->
            <div class="mb-3">
              <label for="jurusan" class="form-label">Jurusan</label>
              <input id="jurusan" name="jurusan" type="text" class="form-control" value="{{ old('jurusan', $user->jurusan) }}">
              <x-input-error class="mt-2" :messages="$errors->get('jurusan')" />
            </div>
          @elseif ($user->role === 'konselor')
            <!-- NIP -->
            <div class="mb-3">
              <label for="nip" class="form-label">NIP</label>
              <input id="nip" name="nip" type="text" class="form-control" value="{{ old('nip', $user->nip) }}">
              <x-input-error class="mt-2" :messages="$errors->get('nip')" />
            </div>
          @endif

          @if (in_array($user->role, ['mahasiswa', 'konselor']))
            <!-- Tanggal Lahir -->
            <div class="mb-3">
              <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
              <input id="tanggal_lahir" name="tanggal_lahir" type="date" class="form-control" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}">
              <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
            </div>

            <!-- WhatsApp -->
            <div class="mb-3">
              <label for="whatsapp" class="form-label">Nomor WhatsApp</label>
              <input id="whatsapp" name="whatsapp" type="text" class="form-control" value="{{ old('whatsapp', $user->whatsapp) }}">
              <x-input-error class="mt-2" :messages="$errors->get('whatsapp')" />
            </div>
          @endif

          <div class="text-center mt-4">
            <button type="submit" class="btn btn-save">Simpan Perubahan</button>
          </div>
        </form>

        @if($user->profile_photo)
          <form method="POST" action="{{ route('profile.delete-photo') }}" onsubmit="return confirm('Yakin ingin menghapus foto profil?');" class="mt-3 text-center px-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus Foto</button>
            @if (session('status') === 'photo-deleted')
              <p class="mt-2 text-sm text-success">Foto profil berhasil dihapus.</p>
            @endif
          </form>
        @endif
      </div>
    </div>
  </div>
</div>

{{-- Script --}}
<script>
  document.getElementById('profile_photo').addEventListener('change', function (e) {
    const file = e.target.files[0];
    const avatarContainer = document.querySelector('.profile-avatar');

    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function (event) {
        if (avatarContainer.tagName === 'DIV') {
          const img = document.createElement('img');
          img.src = event.target.result;
          img.className = 'profile-avatar';
          img.alt = 'Preview Profil';
          avatarContainer.replaceWith(img);
        } else {
          avatarContainer.src = event.target.result;
        }
      };
      reader.readAsDataURL(file);
    }
  });

  // Auto-close alert after 3 seconds
  document.addEventListener('DOMContentLoaded', function () {
    const alert = document.getElementById('success-alert');
    if (alert) {
      setTimeout(() => {
        const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
        bsAlert.close();
      }, 3000);
    }
  });
</script>

{{-- Pastikan Bootstrap JS sudah tersedia --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

