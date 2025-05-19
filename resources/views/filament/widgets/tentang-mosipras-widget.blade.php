<x-filament-widgets::widget>
        {{-- Informasi MOSIPRAS --}}
        <x-filament::card>
            <h2 class="text-xl font-bold mb-4 dark:text-white text-center">Tentang MOSIPRAS</h2>

            <div x-data="{ open: null }" class="space-y-2">
                {{-- 1. Latar Belakang --}}
                <div class="border border-gray-200 dark:border-gray-700 rounded-md">
                    <button @click="open === 101 ? open = null : open = 101"
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 rounded-md">
                        Latar Belakang Inovasi
                        <svg :class="open === 101 ? 'rotate-180' : ''"
                            class="w-4 h-4 transform transition-transform duration-300 text-gray-500 dark:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 101" x-collapse class="px-4 py-2 text-sm text-gray-600 dark:text-white">
                        MOSIPRAS hadir sebagai solusi atas kendala layanan peminjaman sarpras yang masih manual, tidak
                        teratur, dan sulit dilacak. Aplikasi ini mendukung pelayanan cepat, akuntabel, dan mendukung
                        program Zona Integritas di Madrasah Aliyah Negeri 1 Kota Gorontalo.
                    </div>
                </div>

                {{-- 2. Deskripsi Inovasi --}}
                <div class="border border-gray-200 dark:border-gray-700 rounded-md">
                    <button @click="open === 102 ? open = null : open = 102"
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 rounded-md">
                        Deskripsi Inovasi
                        <svg :class="open === 102 ? 'rotate-180' : ''"
                            class="w-4 h-4 transform transition-transform duration-300 text-gray-500 dark:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 102" x-collapse class="px-4 py-2 text-sm text-gray-600 dark:text-white">
                        MOSIPRAS adalah sistem digital untuk mengelola peminjaman barang inventaris di madrasah secara
                        daring. Pengguna bisa mengajukan permohonan, memantau status, hingga mengembalikan barang
                        melalui sistem terintegrasi yang mudah diakses.
                    </div>
                </div>

                {{-- 3. Tujuan Inovasi --}}
                <div class="border border-gray-200 dark:border-gray-700 rounded-md">
                    <button @click="open === 103 ? open = null : open = 103"
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 rounded-md">
                        Tujuan Inovasi
                        <svg :class="open === 103 ? 'rotate-180' : ''"
                            class="w-4 h-4 transform transition-transform duration-300 text-gray-500 dark:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 103" x-collapse class="px-4 py-2 text-sm text-gray-600 dark:text-white">
                        <ul class="list-disc ml-5">
                            <li>Memberikan kemudahan layanan peminjaman sarpras secara digital.</li>
                            <li>Meningkatkan transparansi dan akuntabilitas pengelolaan barang.</li>
                            <li>Meminimalkan kesalahan dan kehilangan data.</li>
                            <li>Mendukung budaya pelayanan prima dan Zona Integritas.</li>
                        </ul>
                    </div>
                </div>

                {{-- 4. Fitur Utama --}}
                <div class="border border-gray-200 dark:border-gray-700 rounded-md">
                    <button @click="open === 104 ? open = null : open = 104"
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 rounded-md">
                        Fitur Utama MOSIPRAS
                        <svg :class="open === 104 ? 'rotate-180' : ''"
                            class="w-4 h-4 transform transition-transform duration-300 text-gray-500 dark:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 104" x-collapse class="px-4 py-2 text-sm text-gray-600 dark:text-white">
                        <ul class="list-disc ml-5">
                            <li>Formulir Peminjaman Online</li>
                            <li>Kalender Jadwal Peminjaman</li>
                            <li>Histori Penggunaan</li>
                            <li>Dashboard Admin</li>
                        </ul>
                    </div>
                </div>

                {{-- 5. Manfaat Inovasi --}}
                <div class="border border-gray-200 dark:border-gray-700 rounded-md">
                    <button @click="open === 105 ? open = null : open = 105"
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 rounded-md">
                        Manfaat Inovasi
                        <svg :class="open === 105 ? 'rotate-180' : ''"
                            class="w-4 h-4 transform transition-transform duration-300 text-gray-500 dark:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 105" x-collapse class="px-4 py-2 text-sm text-gray-600 dark:text-whit">
                        <ul class="list-disc ml-5">
                            <li>Mempermudah peminjaman mandiri oleh siswa/guru.</li>
                            <li>Menghemat waktu staf TU dan mempercepat pengelolaan barang.</li>
                            <li>Meningkatkan keteraturan, transparansi, dan profesionalisme madrasah.</li>
                        </ul>
                    </div>
                </div>

                {{-- 6. Slogan --}}
                <div class="border border-gray-200 dark:border-gray-700 rounded-md">
                    <button @click="open === 106 ? open = null : open = 106"
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 rounded-md">
                        Slogan
                        <svg :class="open === 106 ? 'rotate-180' : ''"
                            class="w-4 h-4 transform transition-transform duration-300 text-gray-500 dark:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 106" x-collapse class="px-4 py-2 text-sm text-gray-600 dark:text-white">
                        <em>“Akses Mudah, Peminjaman Tertib, Pelayanan Simpatik.”</em>
                    </div>
                </div>

                {{-- 7. Penutup --}}
                <div class="border border-gray-200 dark:border-gray-700 rounded-md">
                    <button @click="open === 107 ? open = null : open = 107"
                        class="w-full flex justify-between items-center px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-white bg-gray-100 dark:bg-gray-800 rounded-md">
                        Penutup
                        <svg :class="open === 107 ? 'rotate-180' : ''"
                            class="w-4 h-4 transform transition-transform duration-300 text-gray-500 dark:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open === 107" x-collapse class="px-4 py-2 text-sm text-gray-600 dark:text-white">
                        MOSIPRAS adalah representasi dari pelayanan publik berbasis teknologi di madrasah. Inovasi ini
                        mendorong keterbukaan informasi, keteraturan manajemen, dan kualitas layanan yang modern dan
                        terukur.
                    </div>
                </div>
            </div>
        </x-filament::card>
</x-filament-widgets::widget>
