# Product Requirements Document (PRD)

**Project Name:** Kampus Centralized SSO (Single Sign-On)
**Version:** 1.0

## 1. Tujuan Produk (Product Vision)

Membangun sistem *Identity Provider* terpusat berbasis OAuth2 untuk ekosistem aplikasi kampus. Sistem ini bertujuan menstandardisasi proses autentikasi, menghilangkan duplikasi data *user* di berbagai aplikasi, dan meningkatkan keamanan kredensial. Produk ini juga dirancang sebagai *showcase portfolio* arsitektur *backend* untuk standar perusahaan tech menengah.

## 2. Target Pengguna (User Personas)

- **Civitas Akademika (Dosen & Staf):** Pengguna akhir yang akan login ke berbagai sistem kampus (seperti Sistem Penelitian) menggunakan satu kredensial.
- **Aplikasi Client (Sistem B, C, dst):** Sistem lain di dalam kampus yang membutuhkan data otentikasi user tanpa mengelola *password* sendiri.
- **Super Admin:** Mengelola data master *user*, *role*, dan mendaftarkan aplikasi *client* baru ke dalam ekosistem SSO.

## 3. Scope Fitur MVP (Minimum Viable Product)

### 3.1. Authentication (Core)

- User dapat login menggunakan Email dan Password.
- Sistem menerapkan otentikasi *stateful* (session) untuk web UI SSO, dan menerbitkan *Access Token* (stateless) untuk aplikasi client.
- *Logout* terpusat (membatalkan token dari aplikasi client).

### 3.2. OAuth 2.0 Provider

- Mendukung *Authorization Code Grant Flow*.
- Sistem dapat mendaftarkan *Client ID* dan *Client Secret* untuk aplikasi pihak ketiga (Sistem Penelitian).

### 3.3. User & Role Management

- Sistem dapat menyimpan struktur multi-role (seorang user bisa memiliki banyak *role*).
- Pemisahan data kredensial (*User*) dan data demografis (*Profile*).

## 4. Non-Functional Requirements (NFR)

- **Security:** Password harus di-hash (Bcrypt/Argon2). Aplikasi client tidak boleh pernah menerima atau menyimpan *password* user.
- **Scalability:** Menggunakan UUID versi 4 untuk *Primary Key* tabel `users` guna mencegah isu duplikasi data pada lingkungan terdistribusi.