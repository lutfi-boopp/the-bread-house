{{-- ========================================================================================= --}}
{{-- [FITUR ADMIN] MANAJEMEN KATALOG MENU ROTI                                                 --}}
{{-- Fungsi: Halaman CRUD (Tambah, Edit, Hapus, Upload Foto) Produk Roti UPI Bakery             --}}
{{-- ========================================================================================= --}}
@extends('layouts.admin')

@section('content')
<div class="w-full relative">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 gap-4">
        <div>
            <h2 class="font-heading text-4xl font-bold text-[#693e1b] mb-1">Menu Roti</h2>
            <p class="text-sm text-[#8c7a6b] mt-2">Kelola produk roti artisanal dan ketersediaan stok harian Anda.</p>
        </div>
        <button onclick="openModal('addMenuModal')" class="flex items-center bg-[#693e1b] hover:bg-[#522d12] text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors shadow-sm">
            <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i>
            Tambah Roti Baru
        </button>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div id="success-alert" class="bg-[#e6f5eb] border border-[#1d8a43] text-[#1d8a43] px-4 py-4 rounded-2xl relative mb-6 shadow-sm flex items-center gap-3 transform transition-all duration-300">
        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shrink-0">
            <i data-lucide="check" class="w-5 h-5"></i>
        </div>
        <span class="block sm:inline font-bold">{{ session('success') }}</span>
        <button onclick="document.getElementById('success-alert').style.display='none'" class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
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

    <!-- Product Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
        @php
            $isLow = $product->stock < 15;
            $isCritical = $product->stock < 5;
            $stockStatusColor = $isCritical ? 'bg-[#c42b2b]' : ($isLow ? 'bg-[#b86b16]' : 'bg-[#1d8a43]');
            $stockStatusText = $isCritical ? 'Kritis ('.$product->stock.')' : ($isLow ? 'Menipis ('.$product->stock.')' : 'Tersedia ('.$product->stock.')');
        @endphp
        
        <div class="bg-white border border-[#ece3d4] rounded-3xl overflow-hidden shadow-sm flex flex-col h-full group hover:shadow-md transition-shadow">
            <div class="relative h-48 w-full bg-[#f9f5f0] {{ $product->stock == 0 ? 'grayscale opacity-75' : '' }}">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                @else
                    <div class="w-full h-full flex items-center justify-center text-[#8c7a6b]">
                        <i data-lucide="image" class="w-12 h-12 opacity-50"></i>
                    </div>
                @endif
                <div class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-full flex items-center text-[10px] font-bold text-[#2d251d] shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full {{ $stockStatusColor }} mr-1.5"></span>
                    {{ $product->stock == 0 ? 'Habis' : $stockStatusText }}
                </div>
            </div>
            <div class="p-5 flex-1 flex flex-col">
                <h3 class="font-heading text-lg font-bold text-[#2d251d] mb-1">{{ $product->name }}</h3>
                <p class="text-[10px] font-bold text-[#8c7a6b] uppercase tracking-wider mb-2">{{ $product->category->name ?? 'Kategori' }}</p>
                <p class="text-xs text-[#8c7a6b] leading-relaxed mb-6 flex-1">{{ Str::limit($product->description, 60) }}</p>
                <div class="flex justify-between items-center mt-auto pt-4 border-t border-[#f9f5f0]">
                    <span class="font-bold text-[#693e1b] text-base">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <div class="relative">
                            <button type="button" onclick="toggleDropdown('menu_{{ $product->id }}')" class="p-1.5 text-[#8c7a6b] hover:bg-[#ece3d4] hover:text-[#472c1b] rounded-lg transition-colors focus:outline-none">
                                <i data-lucide="more-vertical" class="w-5 h-5"></i>
                            </button>

                            <div id="dropdown_menu_{{ $product->id }}" class="hidden absolute right-0 bottom-8 mb-1 w-36 bg-white rounded-xl shadow-[0_4px_20px_-5px_rgba(0,0,0,0.15)] border border-[#ece3d4] z-10 p-2 transform origin-bottom-right transition-all text-left">
                                <button onclick="openEditModal({{ $product }}); toggleDropdown('menu_{{ $product->id }}')" class="w-full text-left px-3 py-2 text-sm text-[#8c7a6b] hover:text-[#b86b16] hover:bg-[#fdf0dc] rounded-lg transition-colors flex items-center">
                                    <i data-lucide="pencil" class="w-4 h-4 mr-2"></i> Edit Menu
                                </button>
                                <button type="button" onclick="openDeleteModal('{{ route('admin.menu.destroy', $product->id) }}'); toggleDropdown('menu_{{ $product->id }}')" class="w-full text-left px-3 py-2 text-sm text-[#8c7a6b] hover:text-[#c42b2b] hover:bg-[#fae8e8] rounded-lg transition-colors flex items-center mt-1">
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i> Hapus
                                </button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center bg-white border border-dashed border-[#ece3d4] rounded-3xl">
            <div class="w-16 h-16 bg-[#f9f5f0] rounded-full flex items-center justify-center mx-auto mb-4 text-[#8c7a6b]">
                <i data-lucide="croissant" class="w-8 h-8"></i>
            </div>
            <h4 class="font-heading text-xl font-bold text-[#472c1b] mb-2">Belum Ada Produk Roti</h4>
            <p class="text-sm text-[#8c7a6b] mb-6">Mulai tambahkan produk roti andalan The Bread House sekarang.</p>
            <button onclick="openModal('addMenuModal')" class="inline-flex items-center bg-[#693e1b] hover:bg-[#522d12] text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors shadow-sm">
                <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i> Tambah Roti
            </button>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Tambah Menu -->
<div id="addMenuModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('addMenuModal')"></div>
    <div class="bg-white rounded-3xl w-full max-w-2xl relative z-10 transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto custom-scrollbar">
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-heading text-2xl font-bold text-[#2d251d]">Tambah Roti Baru</h3>
                <button onclick="closeModal('addMenuModal')" class="text-[#8c7a6b] hover:text-[#c42b2b] transition-colors">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-[#8c7a6b] tracking-wider uppercase mb-2">Nama Roti *</label>
                        <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-[#ece3d4] focus:ring-[#693e1b] focus:border-[#693e1b] bg-[#f9f5f0] text-sm text-[#2d251d]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#8c7a6b] tracking-wider uppercase mb-2">Kategori *</label>
                        <select name="category_id" required class="w-full px-4 py-3 rounded-xl border border-[#ece3d4] focus:ring-[#693e1b] focus:border-[#693e1b] bg-[#f9f5f0] text-sm text-[#2d251d]">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-[#8c7a6b] tracking-wider uppercase mb-2">Harga (Rp) *</label>
                        <input type="number" name="price" required min="0" class="w-full px-4 py-3 rounded-xl border border-[#ece3d4] focus:ring-[#693e1b] focus:border-[#693e1b] bg-[#f9f5f0] text-sm text-[#2d251d]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#8c7a6b] tracking-wider uppercase mb-2">Stok Awal *</label>
                        <input type="number" name="stock" required min="0" class="w-full px-4 py-3 rounded-xl border border-[#ece3d4] focus:ring-[#693e1b] focus:border-[#693e1b] bg-[#f9f5f0] text-sm text-[#2d251d]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#8c7a6b] tracking-wider uppercase mb-2">Deskripsi Singkat</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-[#ece3d4] focus:ring-[#693e1b] focus:border-[#693e1b] bg-[#f9f5f0] text-sm text-[#2d251d]"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#8c7a6b] tracking-wider uppercase mb-2">Foto Produk (Opsional)</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 rounded-xl border border-[#ece3d4] bg-[#f9f5f0] text-sm text-[#2d251d] file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#e6f5eb] file:text-[#1d8a43] hover:file:bg-[#d4ecd9]">
                </div>
                
                <div class="relative flex items-center py-2">
                    <div class="flex-grow border-t border-[#ece3d4]"></div>
                    <span class="flex-shrink-0 mx-4 text-[#8c7a6b] text-[10px] font-bold uppercase tracking-wider">Atau via URL (Testing)</span>
                    <div class="flex-grow border-t border-[#ece3d4]"></div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#8c7a6b] tracking-wider uppercase mb-2">URL Foto</label>
                    <input type="url" name="image_url" placeholder="https://contoh.com/foto.jpg" class="w-full px-4 py-3 rounded-xl border border-[#ece3d4] focus:ring-[#693e1b] focus:border-[#693e1b] bg-[#f9f5f0] text-sm text-[#2d251d]">
                </div>

                <div class="pt-4 border-t border-[#ece3d4] flex justify-end gap-3">
                    <button type="button" onclick="closeModal('addMenuModal')" class="px-6 py-3 rounded-xl text-sm font-bold text-[#8c7a6b] hover:bg-[#f9f5f0] transition-colors">Batal</button>
                    <button type="submit" class="px-6 py-3 rounded-xl text-sm font-bold text-white bg-[#1d8a43] hover:bg-[#156e35] transition-colors shadow-sm">Simpan Roti</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Menu -->
<div id="editMenuModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('editMenuModal')"></div>
    <div class="bg-white rounded-3xl w-full max-w-2xl relative z-10 transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto custom-scrollbar">
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-heading text-2xl font-bold text-[#2d251d]">Ubah Data Roti</h3>
                <button onclick="closeModal('editMenuModal')" class="text-[#8c7a6b] hover:text-[#c42b2b] transition-colors">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-[#8c7a6b] tracking-wider uppercase mb-2">Nama Roti *</label>
                        <input type="text" name="name" id="edit_name" required class="w-full px-4 py-3 rounded-xl border border-[#ece3d4] focus:ring-[#693e1b] focus:border-[#693e1b] bg-[#f9f5f0] text-sm text-[#2d251d]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#8c7a6b] tracking-wider uppercase mb-2">Kategori *</label>
                        <select name="category_id" id="edit_category_id" required class="w-full px-4 py-3 rounded-xl border border-[#ece3d4] focus:ring-[#693e1b] focus:border-[#693e1b] bg-[#f9f5f0] text-sm text-[#2d251d]">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-[#8c7a6b] tracking-wider uppercase mb-2">Harga (Rp) *</label>
                        <input type="number" name="price" id="edit_price" required min="0" class="w-full px-4 py-3 rounded-xl border border-[#ece3d4] focus:ring-[#693e1b] focus:border-[#693e1b] bg-[#f9f5f0] text-sm text-[#2d251d]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#8c7a6b] tracking-wider uppercase mb-2">Stok *</label>
                        <input type="number" name="stock" id="edit_stock" required min="0" class="w-full px-4 py-3 rounded-xl border border-[#ece3d4] focus:ring-[#693e1b] focus:border-[#693e1b] bg-[#f9f5f0] text-sm text-[#2d251d]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#8c7a6b] tracking-wider uppercase mb-2">Deskripsi Singkat</label>
                    <textarea name="description" id="edit_description" rows="3" class="w-full px-4 py-3 rounded-xl border border-[#ece3d4] focus:ring-[#693e1b] focus:border-[#693e1b] bg-[#f9f5f0] text-sm text-[#2d251d]"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#8c7a6b] tracking-wider uppercase mb-2">Ganti Foto (Kosongkan jika tidak diubah)</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 rounded-xl border border-[#ece3d4] bg-[#f9f5f0] text-sm text-[#2d251d] file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#fdf0dc] file:text-[#b86b16] hover:file:bg-[#f5e0c3]">
                </div>
                
                <div class="relative flex items-center py-2">
                    <div class="flex-grow border-t border-[#ece3d4]"></div>
                    <span class="flex-shrink-0 mx-4 text-[#8c7a6b] text-[10px] font-bold uppercase tracking-wider">Atau via URL (Testing)</span>
                    <div class="flex-grow border-t border-[#ece3d4]"></div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#8c7a6b] tracking-wider uppercase mb-2">URL Foto Baru</label>
                    <input type="url" name="image_url" id="edit_image_url" placeholder="https://contoh.com/foto.jpg" class="w-full px-4 py-3 rounded-xl border border-[#ece3d4] focus:ring-[#693e1b] focus:border-[#693e1b] bg-[#f9f5f0] text-sm text-[#2d251d]">
                </div>

                <div class="pt-4 border-t border-[#ece3d4] flex justify-end gap-3">
                    <button type="button" onclick="closeModal('editMenuModal')" class="px-6 py-3 rounded-xl text-sm font-bold text-[#8c7a6b] hover:bg-[#f9f5f0] transition-colors">Batal</button>
                    <button type="submit" class="px-6 py-3 rounded-xl text-sm font-bold text-white bg-[#b86b16] hover:bg-[#96540c] transition-colors shadow-sm">Perbarui Roti</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus Menu -->
<div id="deleteMenuModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('deleteMenuModal')"></div>
    <div class="bg-white rounded-3xl w-full max-w-md relative z-10 transform scale-95 transition-transform duration-300">
        <div class="p-8 text-center">
            <div class="w-16 h-16 bg-[#fae8e8] text-[#c42b2b] rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="alert-triangle" class="w-8 h-8"></i>
            </div>
            <h3 class="font-heading text-xl font-bold text-[#2d251d] mb-2">Hapus Produk?</h3>
            <p class="text-sm text-[#8c7a6b] mb-6">Apakah Anda yakin ingin menghapus produk ini? Data yang sudah dihapus tidak dapat dikembalikan.</p>
            
            <form id="deleteForm" method="POST" class="flex gap-3 justify-center">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeModal('deleteMenuModal')" class="px-6 py-2.5 rounded-xl text-sm font-bold text-[#8c7a6b] hover:bg-[#f9f5f0] transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-[#c42b2b] hover:bg-[#a12323] transition-colors shadow-sm">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f9f5f0; 
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #ece3d4; 
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #d4c5b0; 
    }
</style>

<script>
    function toggleDropdown(id) {
        // Close all other dropdowns
        document.querySelectorAll('[id^="dropdown_menu_"]').forEach(el => {
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
        const isClickInside = event.target.closest('[id^="dropdown_menu_"]') || event.target.closest('button[onclick^="toggleDropdown"]');
        if (!isClickInside) {
            document.querySelectorAll('[id^="dropdown_menu_"]').forEach(el => el.classList.add('hidden'));
        }
    });

    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        const modalContent = modal.querySelector('div.bg-white');
        
        modal.classList.remove('hidden');
        // Small delay to allow display:block to apply before animating opacity
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

    function openEditModal(product) {
        // Set action url
        document.getElementById('editForm').action = `/admin/menu/${product.id}/update`;
        
        // Populate fields
        document.getElementById('edit_name').value = product.name;
        document.getElementById('edit_category_id').value = product.category_id;
        document.getElementById('edit_price').value = product.price;
        document.getElementById('edit_stock').value = product.stock;
        document.getElementById('edit_description').value = product.description || '';
        
        openModal('editMenuModal');
    }

    function openDeleteModal(actionUrl) {
        document.getElementById('deleteForm').action = actionUrl;
        openModal('deleteMenuModal');
    }

    // Auto-hide success alert
    setTimeout(function() {
        const alert = document.getElementById('success-alert');
        if(alert) {
            alert.style.opacity = '210';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.style.display = 'none', 300);
        }
    }, 3000);
</script>
@endsection
3