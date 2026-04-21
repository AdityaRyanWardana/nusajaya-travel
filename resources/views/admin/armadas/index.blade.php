@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Manajemen Armada</h2>
        <p class="text-slate-500 text-sm">Kelola semua kendaraan transportasi yang tersedia.</p>
    </div>
    <a href="{{ route('admin.armadas.create') }}" class="flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-900/20">
        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
        Tambah Armada
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 font-semibold">Nama Kendaraan</th>
                    <th class="px-6 py-4 font-semibold">Tipe</th>
                    <th class="px-6 py-4 font-semibold">Kapasitas</th>
                    <th class="px-6 py-4 font-semibold text-right">Harga / Hari</th>
                    <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($armadas as $armada)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-lg bg-slate-100 mr-4 overflow-hidden flex-shrink-0">
                                @if($armada->image)
                                    <img src="{{ Str::startsWith($armada->image, 'http') ? $armada->image : asset('storage/' . $armada->image) }}" alt="{{ $armada->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <i data-lucide="image" class="w-6 h-6"></i>
                                    </div>
                                @endif
                            </div>
                            <span class="text-sm font-bold text-slate-800">{{ $armada->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-1 bg-slate-100 text-slate-600 rounded-md">
                            {{ $armada->type }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $armada->capacity }} Orang</td>
                    <td class="px-6 py-4 text-sm font-bold text-slate-800 text-right">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-slate-400 font-normal">City: Rp {{ number_format($armada->price_city_tour, 0, ',', '.') }}</span>
                            <span>Barelang: Rp {{ number_format($armada->price_barelang, 0, ',', '.') }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('admin.armadas.edit', $armada->id) }}" class="p-2 text-slate-400 hover:text-blue-600 transition-colors">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('admin.armadas.destroy', $armada->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus armada ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-slate-400 italic text-sm">Belum ada armada yang didaftarkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
