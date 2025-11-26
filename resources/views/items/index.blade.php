@extends('layouts.app')

@section('title', 'Data List')

@section('content')
<div class="min-h-screen bg-gray-50 py-12"
     x-data="{
        showEditModal: false,
        editId: '',
        editName: '',
        editAmount: '',
        editDate: '',
        editDesc: '',
        editUrl: '',
        openModal(id, name, amount, date, desc) {
            this.editId = id;
            this.editName = name;
            this.editAmount = amount;
            this.editDate = date;
            this.editDesc = desc;
            this.editUrl = '{{ url('items') }}/' + id;
            this.showEditModal = true;
        }
     }">

    <div class="container mx-auto px-4">

        {{-- Header Section --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-teal-900">Data Management</h2>
                <p class="text-gray-600 mt-1">Daftar semua data yang tersimpan.</p>
            </div>
            <a href="{{ route('items.create') }}"
               class="bg-lime-500 hover:bg-lime-600 text-white font-bold py-2 px-6 rounded-full shadow-lg transform hover:scale-105 transition duration-200 flex items-center">
                <span class="mr-2">+</span> Add New
            </a>
        </div>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        {{-- Table Card --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr class="bg-teal-900 text-white">
                            {{-- KOLOM 1: NAMA --}}
                            <th class="px-5 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                Name
                            </th>

                            {{-- KOLOM 2: AMOUNT --}}
                            <th class="px-5 py-4 text-center text-sm font-semibold uppercase tracking-wider">
                                Amount
                            </th>

                            {{-- KOLOM 3: DATE --}}
                            <th class="px-5 py-4 text-center text-sm font-semibold uppercase tracking-wider">
                                Date
                            </th>

                            {{-- KOLOM 4: ACTIONS --}}
                            <th class="px-5 py-4 text-center text-sm font-semibold uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse ($items as $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">

                            {{-- DATA 1: NAMA --}}
                            <td class="px-5 py-5 text-sm text-left">
                                <div class="flex items-center">
                                    {{-- Ikon Bulat Kecil (Opsional pemanis) --}}
                                    <div class="shrink-0 w-10 h-10 bg-teal-200 rounded-full flex items-center justify-center text-teal-800 font-bold mr-3">
                                        {{ substr($item->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-gray-900 whitespace-no-wrap font-semibold">
                                            {{ $item->name }}
                                        </p>
                                        <p class="text-gray-500 text-xs truncate w-48">{{ $item->description ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- DATA 2: AMOUNT  --}}
                            <td class="px-5 py-5 text-sm text-center">
                                <span class="inline-block px-3 py-1 font-semibold text-teal-900 bg-teal-100 rounded-full">
                                    {{ number_format($item->amount) }}
                                </span>
                            </td>

                            {{-- DATA 3: DATE --}}
                            <td class="px-5 py-5 text-sm text-center">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    {{ \Carbon\Carbon::parse($item->date_input)->format('d M Y') }}
                                </p>
                            </td>

                            {{-- DATA 4: ACTIONS (Rata Tengah + Tombol Jelas) --}}
                            <td class="px-5 py-5 text-sm text-center">
                                <div class="flex justify-center items-center gap-2"> {{-- Gunakan gap-2 agar ada jarak --}}

                                    <button
                                        @click="openModal('{{ $item->id }}', '{{ addslashes($item->name) }}', '{{ $item->amount }}', '{{ $item->date_input }}', '{{ addslashes($item->description) }}')"
                                        type="button"
                                        style="background-color: #2563EB; color: white; padding: 8px 16px; border-radius: 6px; border: none; font-weight: 600; cursor: pointer; transition: 0.3s;"
                                        onmouseover="this.style.opacity='0.8'"
                                        onmouseout="this.style.opacity='1'">
                                        EDIT
                                    </button>

                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" style="display: inline-block; margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                style="background-color: #DC2626; color: white; padding: 8px 16px; border-radius: 6px; border: none; font-weight: 600; cursor: pointer; transition: 0.3s;"
                                                onmouseover="this.style.opacity='0.8'"
                                                onmouseout="this.style.opacity='1'">
                                            DELETE
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-gray-500">
                                Data kosong.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-5 py-5 bg-white border-t">
                {{ $items->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL EDIT (Tetap sama) --}}
    <div x-show="showEditModal"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;"
         x-transition.opacity>
        <div class="fixed inset-0 bg-black opacity-50" @click="showEditModal = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6 relative z-50">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h3 class="text-xl font-bold text-teal-900">Edit Data</h3>
                    <button @click="showEditModal = false" class="text-gray-500 hover:text-gray-700">✕</button>
                </div>
                <form :action="editUrl" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama</label>
                        <input type="text" name="name" x-model="editName" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah</label>
                            <input type="number" name="amount" x-model="editAmount" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal</label>
                            <input type="date" name="date_input" x-model="editDate" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                        <textarea name="description" x-model="editDesc" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500"></textarea>
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="button" @click="showEditModal = false" class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-teal-900 text-white rounded hover:bg-teal-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection