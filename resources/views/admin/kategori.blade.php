{{-- ========================================================================================= --}}
{{-- [FITUR ADMIN] MANAJEMEN KATEGORI ROTI --}}
{{-- Fungsi: Halaman CRUD (Tambah, Edit, Hapus) Kategori Produk Roti UpiBakery --}}
{{-- ========================================================================================= --}}
@extends('layouts.admin')

@section('content')
    <div class="w-full relative">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 gap-4">
            <div>
                <h2 class="font-heading text-4xl font-bold text-[#693e1b] mb-1">Kategori Menu</h2>
                <p class="text-sm text-[#8c7a6b] mt-2">Kelola pengelompokan jenis-jenis roti di toko Anda.</p>
            </div>
            <button onclick="openModal('addKategoriModal')"
                class="flex items-center bg-[#693e1b] hover:bg-[#522d12] text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors shadow-sm">
                <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i>
                Tambah Kategori
            </button>
        </div>

        <!-- Alert Success -->
        @if(session('success'))
            <div id="success-alert"
                class="bg-[#e6f5eb] border border-[#1d8a43] text-[#1d8a43] px-4 py-4 rounded-2xl relative mb-6 shadow-sm flex items-center gap-3 transform transition-all duration-300">
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shrink-0">
                    <i data-lucide="check" class="w-5 h-5"></i>
                </div>
                <span class="block sm:inline font-bold">{{ session('success') }}</span>
                <button onclick="document.getElementById('success-alert').style.display='none'"
                    class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div
                class="bg-[#fae8e8] border border-[#c42b2b] text-[#c42b2b] px-4 py-4 rounded-2xl relative mb-6 shadow-sm flex items-center gap-3">
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shrink-0">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                </div>
                <span class="block sm:inline font-bold">{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-[#fae8e8] border border-[#c42b2b] text-[#c42b2b] px-4 py-4 rounded-2xl relative mb-6 shadow-sm">
                <ul class="list-disc list-inside text-sm font-semibold">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Category Grid / List -->
        <div class="bg-white border border-[#ece3d4] rounded-3xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="text-[#472c1b] text-xs font-bold border-b border-[#ece3d4] bg-[#faf9f6]">
                        <tr>
                            <th class="px-6 py-5">Nama Kategori</th>
                            <th class="px-6 py-5">Jumlah Produk</th>
                            <th class="px-6 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#ece3d4]">
                        @forelse($categories as $category)
                            <tr class="hover:bg-[#fbf9f6] transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-[#fdf0dc] flex items-center justify-center text-[#b86b16] shrink-0">
                                            <i data-lucide="tag" class="w-5 h-5"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-[#2d251d] text-base">{{ $category->name }}</h3>
                                            <p class="text-xs text-[#8c7a6b] mt-0.5">Slug: {{ $category->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 border border-gray-200 text-gray-600 text-xs font-bold shadow-sm">
                                        <i data-lucide="package" class="w-3.5 h-3.5"></i> {{ $category->products_count }} Produk
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button onclick="openEditModal({{ $category }})"
                                            class="p-2 text-[#8c7a6b] hover:bg-[#fdf0dc] hover:text-[#b86b16] rounded-xl transition-colors focus:outline-none bg-[#f9f5f0]"
                                            title="Edit Kategori">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </button>
                                        <button type="button"
                                            onclick="openDeleteModal('{{ route('admin.kategori.destroy', $category->id) }}')"
                                            class="p-2 text-[#8c7a6b] hover:bg-[#fae8e8] hover:text-[#c42b2b] rounded-xl transition-colors focus:outline-none bg-[#f9f5f0]"
                                            title="Hapus Kategori">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center">
                                    <div
                                        class="w-16 h-16 bg-[#f9f5f0] rounded-full flex items-center justify-center mx-auto mb-4 text-[#8c7a6b]">
                                        <i data-lucide="tags" class="w-8 h-8"></i>
                                    </div>
                                    <h4 class="font-heading text-xl font-bold text-[#472c1b] mb-2">Belum Ada Kategori</h4>
                                    <p class="text-sm text-[#8c7a6b]">Tambahkan kategori agar roti Anda lebih terkelompokkan
                                        dengan rapi.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div id="addKategoriModal"
        class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('addKategoriModal')"></div>
        <div
            class="bg-white rounded-3xl w-full max-w-md relative z-10 transform scale-95 transition-transform duration-300">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-heading text-2xl font-bold text-[#2d251d]">Tambah Kategori</h3>
                    <button onclick="closeModal('addKategoriModal')"
                        class="text-[#8c7a6b] hover:text-[#c42b2b] transition-colors">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>

                <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-[#8c7a6b] tracking-wider uppercase mb-2">Nama Kategori
                            *</label>
                        <input type="text" name="name" required placeholder="Contoh: Pastry, Kue Kering..."
                            class="w-full px-4 py-3 rounded-xl border border-[#ece3d4] focus:ring-[#693e1b] focus:border-[#693e1b] bg-[#f9f5f0] text-sm text-[#2d251d]">
                    </div>

                    <div class="pt-4 border-t border-[#ece3d4] flex justify-end gap-3 mt-6">
                        <button type="button" onclick="closeModal('addKategoriModal')"
                            class="px-6 py-3 rounded-xl text-sm font-bold text-[#8c7a6b] hover:bg-[#f9f5f0] transition-colors">Batal</button>
                        <button type="submit"
                            class="px-6 py-3 rounded-xl text-sm font-bold text-white bg-[#1d8a43] hover:bg-[#156e35] transition-colors shadow-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div id="editKategoriModal"
        class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('editKategoriModal')"></div>
        <div
            class="bg-white rounded-3xl w-full max-w-md relative z-10 transform scale-95 transition-transform duration-300">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-heading text-2xl font-bold text-[#2d251d]">Ubah Kategori</h3>
                    <button onclick="closeModal('editKategoriModal')"
                        class="text-[#8c7a6b] hover:text-[#c42b2b] transition-colors">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>

                <form id="editForm" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-[#8c7a6b] tracking-wider uppercase mb-2">Nama Kategori
                            *</label>
                        <input type="text" name="name" id="edit_name" required
                            class="w-full px-4 py-3 rounded-xl border border-[#ece3d4] focus:ring-[#693e1b] focus:border-[#693e1b] bg-[#f9f5f0] text-sm text-[#2d251d]">
                    </div>

                    <div class="pt-4 border-t border-[#ece3d4] flex justify-end gap-3 mt-6">
                        <button type="button" onclick="closeModal('editKategoriModal')"
                            class="px-6 py-3 rounded-xl text-sm font-bold text-[#8c7a6b] hover:bg-[#f9f5f0] transition-colors">Batal</button>
                        <button type="submit"
                            class="px-6 py-3 rounded-xl text-sm font-bold text-white bg-[#b86b16] hover:bg-[#96540c] transition-colors shadow-sm">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Kategori -->
    <div id="deleteKategoriModal"
        class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('deleteKategoriModal')"></div>
        <div
            class="bg-white rounded-3xl w-full max-w-md relative z-10 transform scale-95 transition-transform duration-300">
            <div class="p-8 text-center">
                <div
                    class="w-16 h-16 bg-[#fae8e8] text-[#c42b2b] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="alert-triangle" class="w-8 h-8"></i>
                </div>
                <h3 class="font-heading text-xl font-bold text-[#2d251d] mb-2">Hapus Kategori?</h3>
                <p class="text-sm text-[#8c7a6b] mb-6">Apakah Anda yakin ingin menghapus kategori ini? Kategori tidak bisa
                    dihapus jika sedang digunakan oleh roti.</p>

                <form id="deleteForm" method="POST" class="flex gap-3 justify-center">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="closeModal('deleteKategoriModal')"
                        class="px-6 py-2.5 rounded-xl text-sm font-bold text-[#8c7a6b] hover:bg-[#f9f5f0] transition-colors">Batal</button>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-[#c42b2b] hover:bg-[#a12323] transition-colors shadow-sm">Ya,
                        Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            const modalContent = modal.querySelector('div.bg-white');

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            const modalContent = modal.querySelector('div.bg-white');

            modal.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function openEditModal(category) {
            document.getElementById('editForm').action = `/admin/kategori/${category.id}`;
            document.getElementById('edit_name').value = category.name;
            openModal('editKategoriModal');
        }

        function openDeleteModal(actionUrl) {
            document.getElementById('deleteForm').action = actionUrl;
            openModal('deleteKategoriModal');
        }

        // Auto-hide success alert
        setTimeout(function () {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.style.display = 'none', 300);
            }
        }, 3000);
    </script>
@endsection