# Technical Design Document (TDD) - Sistem SSO Kampus

**Komponen:** Authorization Server (Identity Provider)

## 1. Tech Stack

- **Framework:** Laravel v.13+
- **OAuth2 Server:** Laravel Passport
- **Database:** MySQL
- **Arsitektur:** REST API + SSR Web Form (Login Form)

## 2. Skema Database (ERD)

*Catatan: Tabel OAuth (`oauth_clients`, `oauth_access_tokens`, dll) akan di-generate otomatis oleh Laravel Passport.*

### 2.1. Tabel `users`

| **Column** | **Type** | **Constraints** | **Deskripsi** |
| --- | --- | --- | --- |
| `id` | UUID (char 36) | Primary Key | ID unik user (v4) |
| `email` | String | Unique, Not Null | Email login |
| `password` | String | Not Null | Hashed password |
| `is_active` | Boolean | Default: true | Status akun |
| `timestamps` | Timestamps |  | created_at, updated_at |

### 2.2. Tabel `roles`

| **Column** | **Type** | **Constraints** |
| --- | --- | --- |
| `id` | BigInt | Primary Key, Auto Increment |
| `name` | String | Unique (e.g., 'dosen', 'admin') |

### 2.3. Tabel `user_roles` (Pivot)

| **Column** | **Type** | **Constraints** |
| --- | --- | --- |
| `user_id` | UUID | Foreign Key -> `users.id` |
| `role_id` | BigInt | Foreign Key -> `roles.id` |

### 2.4. Tabel `user_profiles`

| **Column** | **Type** | **Constraints** | **Deskripsi** |
| --- | --- | --- | --- |
| `id` | BigInt | Primary Key, Auto Increment |  |
| `user_id` | UUID | Foreign Key -> `users.id`, Unique | Relasi One-to-One |
| `identifier_number` | String | Unique | NIP/NIDN/NIM |
| `full_name` | String | Not Null | Nama Lengkap |
| `department` | String | Nullable | Fakultas/Prodi |

## 3. API Contracts (Endpoints)

### 3.1. OAuth Endpoints (Bawaan Passport)

- `GET /oauth/authorize`: Menampilkan halaman persetujuan/login untuk *client*.
- `POST /oauth/token`: *Endpoint* bagi server *client* untuk menukar *Authorization Code* dengan *Access Token*.

### 3.2. Resource Endpoints (Custom)

- `GET /api/user`
    - **Auth:** Bearer Token (diperoleh dari Passport).
    - **Response:** JSON berisi data dari tabel `users`, relasi `user_profiles`, dan *array* `roles`. (Digunakan oleh Sistem Penelitian untuk membuat sesi lokal).

## 4. Struktur Folder (Modular Setup)

Untuk menjaga arsitektur *clean code*:

- Pembuatan `app/Services/UserService.php` untuk memisahkan logika registrasi user & pembuatan profil dari Controller.
- Pembuatan `app/Repositories/UserRepository.php` untuk membungkus *query* Eloquent kompleks.