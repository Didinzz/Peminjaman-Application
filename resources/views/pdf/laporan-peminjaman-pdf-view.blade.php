{{-- File: resources/views/pdf/laporan-peminjaman-pdf-view.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Barang</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            /* Font yang baik untuk karakter unicode & PDF */
            margin: 25px;
            font-size: 10px;
            color: #333;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 5px;
            /* Kurangi margin bawah kop surat */
        }

        .kop-surat .logo-kiri,
        .kop-surat .logo-kanan {
            width: 70px;
            /* Sesuaikan ukuran logo */
            height: auto;
            position: absolute;
        }

        .kop-surat .logo-kiri {
            left: 25px;
            /* Posisi dari margin body */
            top: 20px;
            /* Posisi dari margin body */
        }

        .kop-surat .logo-kanan {
            right: 25px;
            /* Posisi dari margin body */
            top: 20px;
            /* Posisi dari margin body */
        }

        .kop-surat h1,
        .kop-surat h2,
        .kop-surat h3,
        .kop-surat p {
            margin: 0;
        }

        .kop-surat h1 {
            font-size: 16px;
            font-weight: bold;
        }

        .kop-surat h2 {
            font-size: 14px;
            font-weight: bold;
        }

        .kop-surat h3 {
            font-size: 12px;
        }

        .kop-surat p {
            font-size: 9px;
        }

        .judul-laporan {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-top: 20px;
            /* Beri jarak dari kop surat */
            margin-bottom: 5px;
            text-decoration: underline;
        }

        .periode-laporan {
            text-align: center;
            font-size: 10px;
            margin-bottom: 15px;
        }

        .info-tambahan {
            margin-bottom: 15px;
            font-size: 10px;
        }

        .info-tambahan p {
            margin: 3px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            /* Sedikit padding lebih */
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #e9e9e9;
            /* Warna abu-abu muda untuk header */
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            font-style: italic;
        }

        .footer-ttd {
            margin-top: 30px;
            /* Jarak dari tabel */
            width: 100%;
            font-size: 10px;
            page-break-inside: avoid;
            /* Hindari page break di dalam blok tanda tangan */
        }

        .footer-ttd .kolom-ttd {
            width: 45%;
            /* Tiap kolom mengambil kurang dari setengah */
            text-align: center;
            display: inline-block;
            /* Agar bisa berdampingan jika muat */
        }

        .footer-ttd .kolom-ttd.kiri {
            float: left;
        }

        .footer-ttd .kolom-ttd.kanan {
            float: right;
        }

        .footer-ttd p {
            margin-bottom: 60px;
            /* Jarak untuk tanda tangan */
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>

<body>
    <div class="kop-surat">
        {{-- Jika Anda punya logo, uncomment dan sesuaikan path --}}
        {{-- <img src="{{ public_path('images/logo_kiri.png') }}" alt="Logo Kiri" class="logo-kiri"> --}}
        {{-- <img src="{{ public_path('images/logo_kanan.png') }}" alt="Logo Kanan" class="logo-kanan"> --}}
        <h1>PEMERINTAH KABUPATEN [NAMA KABUPATEN]</h1>
        <h2>DINAS PENDIDIKAN DAN KEBUDAYAAN</h2>
        <h3>[NAMA SEKOLAH ANDA]</h3>
        <p>Alamat: [Alamat Sekolah Anda] Telp. [Telepon Sekolah]</p>
        <p>Email: [Email Sekolah] Website: [Website Sekolah Jika Ada]</p>
    </div>

    <div class="judul-laporan">LAPORAN PEMINJAMAN BARANG</div>

    @if (isset($tanggalAwal) && isset($tanggalAkhir))
        <div class="periode-laporan">
            Periode: {{ \Carbon\Carbon::parse($tanggalAwal)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY', 'id') }}
            S/D
            {{ \Carbon\Carbon::parse($tanggalAkhir)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY', 'id') }}
        </div>
    @endif

    <div class="info-tambahan">
        @if (isset($jenisBarang) && $jenisBarang)
            <p><strong>Jenis Barang:</strong>
                @if ($jenisBarang === 'bmn_elektronik')
                    BMN Elektronik
                @elseif($jenisBarang === 'bmn_non_elektronik')
                    BMN Non Elektronik
                @else
                    {{ $jenisBarang }} {{-- Tampilkan apa adanya jika tidak cocok --}}
                @endif
            </p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pinjam</th>
                <th>Nama Peminjam</th> {{-- Dari Peminjaman->User --}}
                <th>Nama Barang</th> {{-- Dari Barang --}}
                <th>Jml Pinjam</th> {{-- Dari DetailPeminjaman --}}
                <th>Tgl Kembali (Rencana)</th> {{-- Dari Peminjaman --}}
                <th>Status Pinjam</th> {{-- Dari Peminjaman --}}
                <th>Ket. Peminjaman</th> {{-- Dari Peminjaman --}}
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @if (isset($dataPeminjaman) && $dataPeminjaman->isNotEmpty())
                @foreach ($dataPeminjaman as $detail)
                    {{-- $detail adalah objek DetailPeminjaman --}}
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td class="text-center">
                            {{-- Akses tanggal_pemakaian dari relasi peminjaman --}}
                            {{ $detail->peminjaman ? \Carbon\Carbon::parse($detail->peminjaman->created_at)->isoFormat('D/MM/YY') : '-' }}
                        </td>
                        <td>
                            {{-- Akses nama user dari relasi peminjaman kemudian user --}}
                            {{ $detail->peminjaman && $detail->peminjaman->user ? $detail->peminjaman->user->name : 'N/A' }}
                        </td>
                        <td> 
                            {{-- Akses nama barang dari relasi barang --}}
                            {{ $detail->barang ? $detail->barang->nama_barang : 'N/A' }}
                        </td>
                        <td class="text-center">{{ $detail->jumlah_pinjaman }}</td>
                        <td class="text-center">
                            {{ $detail->peminjaman ? \Carbon\Carbon::parse($detail->peminjaman->tanggal_kembali)->isoFormat('D/MM/YY') : '-' }}
                        </td>
                        <td>{{ $detail->peminjaman ? $detail->peminjaman->status_peminjaman : '-' }}</td>
                        <td>{{ $detail->peminjaman ? $detail->peminjaman->keterangan : '-' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="no-data">Tidak ada data peminjaman untuk periode dan filter yang dipilih.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer-ttd clearfix">
        <div class="kolom-ttd kiri">
            <p>Petugas,</p>
            <p><strong><u>{{ $namaPetugas ?? '(Nama petugas)' }}</u></strong></p>
            <p>NIP. ......................</p>
        </div>
        <div class="kolom-ttd kanan">
            <p>[Nama Kota], {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY', 'Do MMMM YYYY', 'id') }}</p>
            <p>Kepala Sekolah,</p>
            <p><strong><u>{{ $namaKepalaSekolah ?? '(Nama Kepala Sekolah)' }}</u></strong></p>
            <p>NIP. ......................</p>
        </div>
    </div>

</body>

</html>
