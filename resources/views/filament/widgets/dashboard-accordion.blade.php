<x-filament-widgets::widget>
    <x-filament::section>
        <h2 class="text-xl font-bold mb-4 dark:text-white text-center">FAQ</h2>
        <x-filament::card>
            <div x-data="{ open: null }" class="space-y-2">
                {{-- Item 1 --}}
                <div class="border border-gray-200 dark:border-gray-700 rounded-md">
                    <button @click="open === 1 ? open = null : open = 1"
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 rounded-md focus:outline-none">
                        Untuk apa aplikasi ini?
                        <svg :class="open === 1 ? 'rotate-180' : ''"
                            class="w-4 h-4 transform transition-transform duration-300 text-gray-500 dark:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 1" x-collapse class="px-4 py-2 text-sm text-gray-600 dark:text-white">
                        Aplikasi ini dibuat untuk mempermudah pengelolaan barang di sekolah, mengatur peminjaman barang,
                        dan mengecek barang yang sudah dipinjam.
                    </div>
                </div>

                {{-- Item 2 --}}
                <div class="border border-gray-200 dark:border-gray-700 rounded-md">
                    <button @click="open === 2 ? open = null : open = 2"
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 rounded-md focus:outline-none">
                        Bagaimana cara mengajukan peminjaman barang?
                        <svg :class="open === 2 ? 'rotate-180' : ''"
                            class="w-4 h-4 transform transition-transform duration-300 text-gray-500 dark:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 2" x-collapse class="px-4 py-2 text-sm text-gray-600 dark:text-white">
                        Silakan masuk ke menu <strong>Pengajuan</strong> dan isi form sesuai kebutuhan dan jangan lupa
                        menyertakan surat peminjaman.
                        Pastikan semua
                        data lengkap dan benar sebelum disubmit.
                    </div>
                </div>

                {{-- Item 3 --}}
                <div class="border border-gray-200 dark:border-gray-700 rounded-md">
                    <button @click="open === 3 ? open = null : open = 3"
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 rounded-md focus:outline-none">
                        Apa yang terjadi setelah saya mengajukan peminjaman?
                        <svg :class="open === 3 ? 'rotate-180' : ''"
                            class="w-4 h-4 transform transition-transform duration-300 text-gray-500 dark:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 3" x-collapse class="px-4 py-2 text-sm text-gray-600 dark:text-white">
                        Pengajuan Anda akan masuk ke dalam daftar verifikasi dan <strong>menunggu konfirmasi dari
                            Wakasarpras</strong>.
                        Anda dapat melihat status pengajuan di halaman pengajuan.
                    </div>
                </div>

                {{-- Item 4 --}}
                <div class="border border-gray-200 dark:border-gray-700 rounded-md">
                    <button @click="open === 4 ? open = null : open = 4"
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 rounded-md focus:outline-none">
                        Bagaimana cara mengambil barang yang disetujui?
                        <svg :class="open === 4 ? 'rotate-180' : ''"
                            class="w-4 h-4 transform transition-transform duration-300 text-gray-500 dark:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 4" x-collapse class="px-4 py-2 text-sm text-gray-600 dark:text-white">
                        Setelah pengajuan disetujui, Anda dapat mengambil barang di bagian <strong>Petugas
                            Barang</strong>.
                        Tunjukkan bukti
                        persetujuan dari sistem saat mengambil.
                    </div>
                </div>

                {{-- Item 5 --}}
                <div class="border border-gray-200 dark:border-gray-700 rounded-md">
                    <button @click="open === 5 ? open = null : open = 5"
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 rounded-md focus:outline-none">
                        Kapan saya harus mengembalikan barang?
                        <svg :class="open === 5 ? 'rotate-180' : ''"
                            class="w-4 h-4 transform transition-transform duration-300 text-gray-500 dark:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 5" x-collapse class="px-4 py-2 text-sm text-gray-600 dark:text-white">
                        Barang harus dikembalikan <strong>sebelum atau pada tanggal pengembalian</strong> yang Anda
                        tentukan saat
                        pengajuan. Keterlambatan akan dikenakan status "Terlambat".
                    </div>
                </div>

                {{-- Item 6 --}}
                <div class="border border-gray-200 dark:border-gray-700 rounded-md">
                    <button @click="open === 6 ? open = null : open = 6"
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 rounded-md focus:outline-none">
                        Apa yang terjadi jika saya tidak atau terlambat mengembalikan barang atau barang dikembalikan
                        dalam keadaan rusak?
                        <svg :class="open === 6 ? 'rotate-180' : ''"
                            class="w-4 h-4 transform transition-transform duration-300 text-gray-500 dark:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 6" x-collapse class="px-4 py-2 text-sm text-gray-600 dark:text-white">
                        Jika barang yang dikembalikan <strong>terlambat atau rusak</strong> maka akan dikenakan sanksi
                        sesuai dengna kebijakan sekolah.
                    </div>
                </div>
            </div>
        </x-filament::card>
    </x-filament::section>
</x-filament-widgets::widget>
