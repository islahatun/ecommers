untuk mengirim email, email aktif yang akan di jadikan email pengirim harus di setting terlebih dahulu.

---- jika menggunakan gmail
MAIL_MAILER=smtp

MAIL_HOST=smtp.gmail.com

MAIL_PORT=587

MAIL_USERNAME=namaemailanda@gmail.com

MAIL_PASSWORD=passwordemailaplikasi

MAIL_ENCRYPTION=tls

MAIL_FROM_ADDRESS="namaemailanda@gmail.com"

MAIL_FROM_NAME="${APP_NAME}"

----- untuk MAIL_PASSWORD anda harus setting di akun email nya dengan cara 
1. masuk ke dalam email anda
2. klik kelola akun google anda
3. klik menu keamanan (scurity)
4. cari " cara anda login ke google"
5. pilih verifikasi 2 langkah
6. anda akan di alihkan ke halaman verifikasi 2 langkah, scroll sampai bawah sampai menemukan sandi aplikasi
7. klik sandi aplikasi
8. masukan nama aplikasi yang akan dihubungkan
9. klik tombol "buat"
10. akan muncul generate password untuk aplikasi
11. salin password tersebut ke .env MAIL_PASSWORD
