@php
    $user = auth()->user();
@endphp


<section class="space-y-6">
    @if ($user->role === 'admin')
        <div class="p-4 bg-red-100 text-red-700 rounded-md">
            Admin tidak bisa menghapus akun.
        </div>
    @endif
</section>

<!-- Modal -->
@if ($user->role !== 'admin')
    <div id="deleteAccountModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-bold mb-2">DELETE ACCOUNT</h2>
            <h5 class="text-base font-semibold text-gray-900 mb-2">Apakah Anda yakin ingin menghapus akun?</h5>
            <p class="text-sm text-gray-600 mb-4">Akun Anda akan dihapus secara permanen. Silakan masukkan password Anda untuk konfirmasi.</p>

            <input type="password" name="password" placeholder="Password" required class="w-full mb-4 border rounded px-3 py-2" />

            <div class="flex justify-end gap-2">
                <button type="button" id="closeDeleteModal" class="btn-cancel">Batal</button>
                <button type="submit" class="danger-button">Hapus Akun</button>
            </div>
        </form>
    </div>
@endif


<!-- Style -->
<style>
    .danger-button {
         background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
        background-color: #ff6b8b;
        color: white;
        font-weight: bold;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 14px;
        transition: background-color 0.2s ease;
    }

    .danger-button:hover {
        background-color: #ff4a6f;
    }

    .btn-disabled {
        background-color: #ccc;
        color: #666;
        font-weight: bold;
        padding: 10px 20px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        cursor: not-allowed;
    }

    .btn-cancel {
        background-color: #e5e7eb;
        color: #111827;
        font-weight: bold;
        padding: 10px 20px;
        border-radius: 10px;
        border: none;
    }

    .modal.hidden {
        display: none;
    }
</style>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openBtn = document.getElementById('openDeleteModal');
        const closeBtn = document.getElementById('closeDeleteModal');
        const modal = document.getElementById('deleteAccountModal');

        openBtn?.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        closeBtn?.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    });
</script>
@endpush
