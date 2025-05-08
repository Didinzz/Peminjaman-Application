
       Revisi komas 
<!-- 1. tambahkan bukti foto ketika barang yang di pinjam telah di serahkan oleh peminjam (petugas ) -->
<!-- 2. tambahkan pembeda Antra tanggal pengajuan  peminjaman di input dengan tanggal pemakaian ketika barang akan di gunakan  -->
<!-- 3. tambahkan opsi pembatalan peminjaman ketika peminjam sudah mengajukan barang yg di pinjam d cantumkan alasan kenapa di batalkan peminjaman secara tiba2  -->
<!-- 4. tambakan from pemakaian di ajukan peminjaman barang harus di ajukan dua hari sebelum di pinjam  -->
<!-- 5. tambahkan opsi status barang (alasan) pengambilan ketika peminjam mengembalikan barang  -->
<!-- 6. Sertakan nama petugas yang memberikan barang ke peminjam dan jga ketika pengambilan barang sertakan foto petugas dan barang  -->
<!-- 7. Tambalan 3 opsi yaitu barang baik, rusak tapi bisa di pakai , rusak sudah tidak bisa di pakai -->
<!-- 8. tambahkan status peminjaman "terlambat dikembalikan" jika peminjam terlambat mengembalikan barang -->



ADMIN/petugas
   <!-- - tambahkan bukti foto peminjam, nama petugas yang memberikan barang dan ubah status peminjaman menjadi barang sudah diambil untuk pengambilan dan pengembalian kurang di atur ulang shieldnya -->
   <!-- - ketika pengembalian petugas juga menuliskan siapa petugas yang menerima barang ketika dikembalikan validasi tanggal pengembalian -->
   <!-- - ketika barang dikembalikan oleh peminjam, petugas dapat memverifikasi kondisi barang yang dipinjam, bisa jadi barang dipinjam ada beberapa yang rusak dan barang yang rusak tidak akan kembali masuk ke stok barang, masalahnya disini adalah bagaimana cara admin memverifikasi jika barang dipinjam 3 dan dikembalikan rusak 1, maka yang kembali ke stok barang adalah 2 tapi masih ada kendala pada   validasi tanggal mengubah tanggal pengajuan menjadi tanggal pemakaian di form -->
   <!-- - sesuaikan infolist -->

    
   <!-- - inventaris barang bisa ditambah dengan kondisi barang nantinya akan difilter tapi yang tampil masuk distock hanya barang bagus saja, nanti untuk barang yang kondisi rusak bisa dipakai dan rusak tidak bisa dipakai itu difilter dan ketahuan ada berapa -->
   <!-- - memverifikasi pengajuan pembatalan peminjaman yang dilakukan oleh peminjam. -->
   <!-- - jangan lupa perika pengembalian kondisi barang ketika peminjaman ditolak -->
   <!-- - perbaiki tanggal pemakaian tidak bisa dihari yang paling minimal error field must be a date after or equal to  -->
   <!-- - perbaiki fleksibilitas deskripsi -->


Wakasarpras
    <!-- - memverifikasi pengajuan pembatalan peminjaman yang dilakukan oleh peminjam, ketika pembatalan disetuji baru stok barang kembali ke stok barang. -->
    
Peminjam
    <!-- -tambahkan/ubah tanggal pengajuan menjadi tanggal kapan pemakaiannya dan buat validasi jika mengisi tanggal pemakaian itu tidak boleh kurang dari 2 hari tanggal pengajuan dibuat, contohnya pengajuan dibuat hari senin, maka tanggal pemakaian tidak boleh dipilih tanggal pemakaian hari selasa, hanya bisa dimulai dipilih hari rabu -->
    <!-- - tambahkan opsi pembatalan peminjaman ketika peminjam sudah mengajukan barang yang dipinjam dan validasi pembatalan hanya bisa dilakukan ketika status barang telah diajukan dan disetuji oleh petugas, serta berikan alasan pembatalan peminjaman jangan lupa validasi menggunakan shield dan cari cara untuk menghilangkan resource didalam shield -->


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

        Pertanyaan untuk asistensi
        - apakah pengisian tanggal pengembalian boleh di isi sebelum tanggal hari ini? karena mengecega apabila petugas lupa melakukan konfirmasi pengembalian

 