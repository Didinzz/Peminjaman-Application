<x-filament-panels::page>
    {{--
        Formulir akan dirender di sini.
        Karena field-fieldnya reaktif, tidak perlu tag <form> atau tombol submit manual.
        Filament/Livewire akan menangani pembaruan secara otomatis.
    --}}
    <div class="mb-6">
        {{ $this->form }}
    </div>

    <x-filament::section>
        <x-slot name="heading">
            Preview Laporan PDF
        </x-slot>

        @if (!$pdfUrl && $showPdfPlaceholder)
            {{-- Placeholder jika $pdfUrl masih kosong atau filter belum lengkap --}}
            <div class="border border-gray-300 dark:border-gray-700 flex flex-col items-center justify-center rounded-lg shadow-sm bg-gray-50 dark:bg-gray-800/50 min-h-[300px] py-10 text-center">
                <div class="p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 text-gray-400 dark:text-gray-500 mx-auto">
                        <path d="M4 2.5A2.5 2.5 0 0 1 6.5 0h11A2.5 2.5 0 0 1 20 2.5v19A2.5 2.5 0 0 1 17.5 24h-11A2.5 2.5 0 0 1 4 21.5v-19ZM6.5 2A.5.5 0 0 0 6 2.5v19a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 .5-.5v-19a.5.5 0 0 0-.5-.5h-11Z"/>
                        <path d="M7.502 19.001a.502.502 0 0 1-.502-.502v-13a.502.502 0 0 1 .502-.502h4.497a.5.5 0 0 1 .5.5v2.001a.5.5 0 0 1-.5.5h-2.497v3h1.996a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1.996v3.001a.5.5 0 0 1-.502.502h-1.496Z"/>
                        <path d="M15.001 11.002H13V9.501a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 .5.5v1.501Z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">
                        Area Preview PDF
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Laporan PDF akan ditampilkan di sini. Pastikan semua filter yang dibutuhkan telah diisi.
                    </p>
                </div>
            </div>
        @elseif ($pdfUrl)
            {{-- Iframe akan tampil jika $pdfUrl sudah diisi --}}
            <div>
                {{-- Menambahkan key unik ke iframe bisa membantu memaksa reload saat src berubah,
                     meskipun biasanya perubahan src sudah cukup. Timestamp bisa jadi key. --}}
                <iframe key="{{ $pdfUrl }}-{{ now()->timestamp }}" src="{{ $pdfUrl }}" class="w-full h-screen min-h-[70vh] border rounded-md" frameborder="0" title="Preview Laporan PDF"></iframe>
            </div>
        @endif
    </x-filament::section>

</x-filament-panels::page>