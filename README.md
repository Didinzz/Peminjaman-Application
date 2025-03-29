
ADMIN
    <!-- - buat akun user dan role peminjam -->
    <!-- - input data barang (nama, foto, jumlah, jenis barang) -->
    - button barang dikembalikan (form foto barang dikembalikan & tanggal dikembalikan)

Wakasarpras
    - Menerima peminjaman barang dari peminjam
    <!-- - Menyetujui/Menolak peminjaman barang -->
    
Peminjam
    <!-- - Melakukan pengisian peminjaman barang (nama barang apa saja yang dipinjam, jumlah pinjaman, tanggal peminjaman, tanggal pengembalian, surat peminjaman) -->
    - Menunggu verifikasi peminjaman barang dari wakasarpras

    Tabel Peminjaman
        - user id
        - tanggal peminjaman
        - tanggal pengembalian
        - surat peminjaman
        - status peminjaman (diajukan, disetujui, ditolak, dikembalikan)
        - foto pengembalia
        - tanggal dikembalikan
        - alasan penolakan

    Tabel Detail Peminjaman
        - peminjaman id
        - barang id
        - stok tersedia
        -jumlah pinjaman