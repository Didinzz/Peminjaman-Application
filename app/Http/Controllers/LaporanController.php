<?php

namespace App\Http\Controllers;

use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf; // Atau library PDF Anda
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function streamLaporanPeminjaman(Request $request)
    {
        $tanggalAwal = $request->query('tanggal_mulai');
        $tanggalAkhir = $request->query('tanggal_selesai');
        $jenisBarangFilter = $request->query('jenis_barang');
        $petugasId = $request->query('nama_petugas');
        $namaKepalaSekolah = $request->query('nama_kepala_sekolah');

        // Ambil nama petugas berdasarkan ID
        $namaPetugasDariForm = null;
        if ($petugasId) {
            $userPetugasDariForm = User::find($petugasId);
            if ($userPetugasDariForm) {
                $namaPetugasDariForm = $userPetugasDariForm->name;
            }
        }
        $namaPetugasDisplay = $namaPetugasDariForm ?? '(Petugas Tidak Dipilih)';

        // Query menggunakan explicit join (yang sudah terbukti bekerja)
        $query = DetailPeminjaman::with(['peminjaman.user', 'barang'])
            ->join('peminjamen', 'detail_peminjamen.peminjaman_id', '=', 'peminjamen.id')
            ->join('barangs', 'detail_peminjamen.barang_id', '=', 'barangs.id')
            ->where('peminjamen.status_peminjaman', 'dikembalikan');

        // Filter tanggal
        if ($tanggalAwal && $tanggalAkhir) {
            $start = Carbon::parse($tanggalAwal)->startOfDay();
            $end = Carbon::parse($tanggalAkhir)->endOfDay();
            $query->whereBetween('peminjamen.created_at', [$start, $end]);
        }

        // Filter petugas
        if ($namaPetugasDariForm) {
            $query->where(function ($q) use ($namaPetugasDariForm) {
                $q->where('peminjamen.nama_petugas_pengambilan', $namaPetugasDariForm)
                    ->orWhere('peminjamen.nama_petugas_pengembalian', $namaPetugasDariForm);
            });
        }

        // Filter jenis barang
        if ($jenisBarangFilter) {
            $kategoriMapping = [
                'bmn_elektronik' => 'Elektronik',
                'bmn_non_elektronik' => 'Non-Elektronik',
            ];
            $dbKategori = $kategoriMapping[$jenisBarangFilter] ?? null;

            if ($dbKategori) {
                $query->where('barangs.kategori_barang', $dbKategori);
            }
        }

        // Select hanya kolom detail_peminjamen untuk menghindari konflik
        $query->select('detail_peminjamen.*');

        // Ordering
        $query->orderBy('peminjamen.created_at', 'asc')
            ->orderBy('detail_peminjamen.id', 'asc');

        $dataPeminjaman = $query->get();

        // Load relationship peminjaman secara manual
        $dataPeminjaman->load(['peminjaman.user', 'barang']);

        // Pastikan data ditemukan
        if ($dataPeminjaman->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        // dd($dataPeminjaman);

        $dataForPdf = [
            'dataPeminjaman' => $dataPeminjaman,
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'jenisBarang' => $jenisBarangFilter,
            'namaPetugas' => $namaPetugasDisplay,
            'namaKepalaSekolah' => $namaKepalaSekolah,
        ];

        $pdf = Pdf::loadView('pdf.laporan-peminjaman-pdf-view', $dataForPdf);
        return $pdf->stream('laporan_peminjaman_dikembalikan_' . date('Ymd_His') . '.pdf');
    }
}
