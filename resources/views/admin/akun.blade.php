{{-- ========================================================================================= --}}
{{-- [FITUR ADMIN] MANAJEMEN AKUN PENGGUNA (ADMIN & KASIR)                                  --}}
{{-- Fungsi: Menambah, mengedit role, memperbarui kata sandi, & menghapus akun petugas        --}}
{{-- ========================================================================================= --}}
@extends('layouts.admin')

@section('content')
<div class="w-full">
    <!-- Header -->
    <div class="flex justify-between items-end mb-10">
        <div>
            <h2 class="font-heading text-4xl font-bold text-[#693e1b] mb-1">Manajemen Akun</h2>
            <p class="text-sm text-[#8c7a6b] mt-2">Kelola akses untuk Admin dan Kasir The Bread House.</p>
        </div>
        
        <button onclick="openModal('create')" class="bg-[#693e1b] hover:bg-[#522d12] text-white px-6 py-2.5 rounded-xl text-sm font-bold transition-colors shadow-sm flex items-center">
            <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i> Tambah Akun
        </button>
    </div>

    @if($errors->any())
        <div class="bg-[#fadada] text-[#c94040] px-4 py-3 rounded-xl mb-6 shadow-sm">
            <div class="flex items-center mb-1">
                <i data-lucide="alert-triangle" class="w-5 h-5 mr-3"></i>
                <span class="font-bold text-sm">Gagal menyimpan data:</span>
            </div>
            <ul class="list-disc pl-10 text-xs font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#ece3d4] flex items-center">
            <div class="w-14 h-14 rounded-2xl bg-[#fdf0dc] text-[#b86b16] flex items-center justify-center mr-5 shadow-sm">
                <i data-lucide="shield-check" class="w-7 h-7"></i>
            </div>
            <div>
                <div class="text-[10px] font-bold text-[#8c7a6b] tracking-wider uppercase mb-1">Total Admin</div>
                <h3 class="font-heading text-3xl font-bold text-[#693e1b]">{{ $totalAdmin }} <span class="text-sm font-medium text-[#8c7a6b] font-sans">Orang</span></h3>
            </div>
        </div>
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#ece3d4] flex items-center">
            <div class="w-14 h-14 rounded-2xl bg-[#f0e8dc] text-[#693e1b] flex items-center justify-center mr-5 shadow-sm">
                <i data-lucide="calculator" class="w-7 h-7"></i>
            </div>
            <div>
                <div class="text-[10px] font-bold text-[#8c7a6b] tracking-wider uppercase mb-1">Total Kasir</div>
                <h3 class="font-heading text-3xl font-bold text-[#693e1b]">{{ $totalKasir }} <span class="text-sm font-medium text-[#8c7a6b] font-sans">Orang</span></h3>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-3xl shadow-sm border border-[#ece3d4] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-[#8c7a6b] bg-[#f9f5f0] border-b border-[#ece3d4] uppercase tracking-widest font-bold">
                    <tr>
                        <th class="px-6 py-5">Pengguna</th>
                        <th class="px-6 py-5">Peran (Role)</th>
                        <th class="px-6 py-5">Terdaftar Sejak</th>
                        <th class="px-6 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#ece3d4]">
                    @foreach($users as $user)
                    <tr class="hover:bg-[#fcfaf8] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full {{ $user->role === 'admin' ? 'bg-[#fdf0dc] text-[#b86b16]' : 'bg-[#e6e5df] text-[#687162]' }} flex items-center justify-center font-bold text-sm shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-[#472c1b]">{{ $user->name }}</div>
                                    <div class="text-xs text-[#8c7a6b]">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-[#fdf0dc] text-[#b86b16]">
                                    <i data-lucide="shield" class="w-3 h-3 mr-1"></i> Admin
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-[#e6e5df] text-[#687162]">
                                    <i data-lucide="monitor" class="w-3 h-3 mr-1"></i> Kasir
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-[#8c7a6b] font-medium">
                            {{ $user->created_at->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap relative">
                            <button type="button" onclick="toggleDropdown('account_{{ $user->id }}')" class="p-2 text-[#8c7a6b] hover:bg-[#ece3d4] hover:text-[#472c1b] rounded-lg transition-colors focus:outline-none">
                                <i data-lucide="more-vertical" class="w-5 h-5"></i>
                            </button>

                            <div id="dropdown_account_{{ $user->id }}" class="hidden absolute right-6 top-10 mt-1 w-36 bg-white rounded-xl shadow-lg border border-[#ece3d4] z-50 p-2 transform origin-top-right transition-all text-left">
                                <button onclick="openModal('edit', {{ $user->toJson() }}); toggleDropdown('account_{{ $user->id }}')" class="w-full text-left px-3 py-2 text-sm text-[#8c7a6b] hover:text-[#b86b16] hover:bg-[#fdf0dc] rounded-lg transition-colors flex items-center">
                                    <i data-lucide="edit-2" class="w-4 h-4 mr-2"></i> Edit Akun
                                </button>
                                <form id="deleteForm-{{ $user->id }}" action="{{ route('admin.akun.destroy', $user->id) }}" method="POST" class="w-full mt-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}'); toggleDropdown('account_{{ $user->id }}')" class="w-full text-left px-3 py-2 text-sm text-[#8c7a6b] hover:text-[#c42b2b] hover:bg-[#fae8e8] rounded-lg transition-colors flex items-center">
                                        <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div id="accountModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-[#332115]/40 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="accountModalContent">
        <div class="bg-[#f9f5f0] px-6 py-5 border-b border-[#ece3d4] flex justify-between items-center">
            <h3 class="font-heading text-xl font-bold text-[#693e1b]" id="modalTitle">Tambah Akun Baru</h3>
            <button onclick="closeModal()" class="text-[#8c7a6b] hover:text-[#c94040] transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        
        <form id="accountForm" method="POST" action="{{ route('admin.akun.store') }}" class="px-6 py-6 space-y-4">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div>
                <label class="block text-xs font-bold text-[#8c7a6b] uppercase tracking-wider mb-2">Nama Lengkap</label>
                <input type="text" name="name" id="inputName" required class="w-full px-4 py-3 bg-[#faf9f6] border border-[#ece3d4] rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#693e1b]/20 focus:border-[#693e1b] transition-all">
            </div>
            
            <div>
                <label class="block text-xs font-bold text-[#8c7a6b] uppercase tracking-wider mb-2">Email</label>
                <input type="email" name="email" id="inputEmail" required class="w-full px-4 py-3 bg-[#faf9f6] border border-[#ece3d4] rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#693e1b]/20 focus:border-[#693e1b] transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-[#8c7a6b] uppercase tracking-wider mb-2">Peran (Role)</label>
                <select name="role" id="inputRole" required class="w-full px-4 py-3 bg-[#faf9f6] border border-[#ece3d4] rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#693e1b]/20 focus:border-[#693e1b] transition-all appearance-none cursor-pointer">
                    <option value="kasir">Kasir</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#8c7a6b] uppercase tracking-wider mb-2">Password <span id="passwordHint" class="text-gray-400 font-normal ml-1"></span></label>
                <input type="password" name="password" id="inputPassword" required class="w-full px-4 py-3 bg-[#faf9f6] border border-[#ece3d4] rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#693e1b]/20 focus:border-[#693e1b] transition-all placeholder-gray-400" placeholder="Minimal 8 karakter">
            </div>

            <div class="pt-4 flex gap-3">
                <button type="button" onclick="closeModal()" class="w-full bg-white border border-[#ece3d4] hover:bg-[#f9f5f0] text-[#693e1b] py-3 rounded-xl font-bold text-sm transition-colors">
                    Batal
                </button>
                <button type="submit" class="w-full bg-[#693e1b] hover:bg-[#522d12] text-white py-3 rounded-xl font-bold text-sm transition-colors shadow-sm">
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleDropdown(id) {
        // Close all other dropdowns
        document.querySelectorAll('[id^="dropdown_account_"]').forEach(el => {
            if(el.id !== 'dropdown_' + id) el.classList.add('hidden');
        });
        
        // Toggle the clicked dropdown
        const dropdown = document.getElementById('dropdown_' + id);
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        }
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const isClickInside = event.target.closest('[id^="dropdown_account_"]') || event.target.closest('button[onclick^="toggleDropdown"]');
        if (!isClickInside) {
            document.querySelectorAll('[id^="dropdown_account_"]').forEach(el => el.classList.add('hidden'));
        }
    });

    function openModal(mode, user = null) {
        const modal = document.getElementById('accountModal');
        const content = document.getElementById('accountModalContent');
        const form = document.getElementById('accountForm');
        
        if (mode === 'edit' && user) {
            document.getElementById('modalTitle').innerText = 'Edit Akun';
            document.getElementById('formMethod').value = 'PUT';
            form.action = `/admin/akun/${user.id}`;
            
            document.getElementById('inputName').value = user.name;
            document.getElementById('inputEmail').value = user.email;
            document.getElementById('inputRole').value = user.role;
            
            const passInput = document.getElementById('inputPassword');
            passInput.required = false;
            passInput.value = '';
            document.getElementById('passwordHint').innerText = '(Kosongkan jika tidak ingin mengubah password)';
        } else {
            document.getElementById('modalTitle').innerText = 'Tambah Akun Baru';
            document.getElementById('formMethod').value = 'POST';
            form.action = `{{ route('admin.akun.store') }}`;
            
            document.getElementById('inputName').value = '';
            document.getElementById('inputEmail').value = '';
            document.getElementById('inputRole').value = 'kasir';
            
            const passInput = document.getElementById('inputPassword');
            passInput.required = true;
            passInput.value = '';
            document.getElementById('passwordHint').innerText = '';
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Animasi masuk
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('accountModal');
        const content = document.getElementById('accountModalContent');
        
        // Animasi keluar
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }

    function confirmDelete(userId, userName) {
        Swal.fire({
            title: 'Hapus Akun?',
            text: `Apakah Anda yakin ingin menghapus akun ${userName}? Tindakan ini tidak dapat dibatalkan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#c94040',
            cancelButtonColor: '#8c7a6b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-3xl'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm-' + userId).submit();
            }
        });
    }
</script>
@endsection
