# Movies RESTFull API Service

Ini adalah sebuah RESTFull API Service sederhana yang menyediakan operasi CRUD (Create, Read, Update, Delete) untuk mengelola data Film.\
Aplikasi ini dibuat menggunakan framework Laravel 10 dan menggunakan database MySQL.

## Instalasi

1. Clone repository

```bash
  git clone https://github.com/saputra41/backend-xsis.git
```

2. Pindah ke directory aplikasi

```bash
  cd backend-xsis
```

3. Install dependensi menggunakan Composer

```bash
composer install
```

4. Copy file .env-example dengan .env

```bash
cp .env.example .env
```

4. Generate application key

```bash
php artisan key:generate
```

6. Siapkan database dengan mengatur file .env dengan kredensial database Anda dan jalankan migrasi dan seed untuk menambahkan contoh data:

```bash
php artisan migrate --seed
```

7. Menjalankan secara lokal

```bash
php artisan serve
```

## API Reference

#### - Mengambil semua film

```http
  GET /movies
```

##### Example Response Success

```json
{
    "response": true,
    "message": "Movies found",
    "details": [
        {
            "id": 10,
            "title": "Oppenheimer1",
            "description": "Oppenheimer adalah film biografi sejarah Amerika Serikat tahun 2023 yang disutradarai oleh Christopher Nolan dan diproduseri oleh Christopher Nolan, Emma Thomas dan Charles Roven.1",
            "rating": 9.1,
            "image": "64b985958d589.JPG",
            "created_at": "2023-07-20 19:05:57",
            "updated_at": "2023-07-20 19:06:55"
        }
    ]
}
```

#### - Mengambil detail salah satu film

```http
  GET /movies/${id}
```

| Parameter | Type      | Description                              |
| :-------- | :-------- | :--------------------------------------- |
| `id`      | `integer` | **Required**. Id film yang ingin diambil |

##### Example Response Success

```json
{
    "response": true,
    "message": "Movie found",
    "details": {
        "id": 10,
        "title": "Oppenheimer1",
        "description": "Oppenheimer adalah film biografi sejarah Amerika Serikat tahun 2023 yang disutradarai oleh Christopher Nolan dan diproduseri oleh Christopher Nolan, Emma Thomas dan Charles Roven.1",
        "rating": 9.1,
        "image": "64b985958d589.JPG",
        "created_at": "2023-07-20 19:05:57",
        "updated_at": "2023-07-20 19:06:55"
    }
}
```

##### Example Response Failed

```json
{
    "response": false,
    "message": "Movie not found"
}
```

#### - Membuat data film

```http
  POST /movies
```

##### Header

```
Content-Type: application/json
```

##### Body

```json
{
    "title": {
        "type": "string",
        "description": "Nama film, Length 255, (Required)",
        "example": "Oppenheimer"
    },
    "description": {
        "type": "text",
        "description": "Deskripsi film",
        "example": "Oppenheimer adalah film biografi sejarah Amerika Serikat tahun 2023 yang disutradarai oleh Christopher Nolan dan diproduseri oleh Christopher Nolan, Emma Thomas dan Charles Roven."
    },
    "rating": {
        "type": "float",
        "description": "Rating film, Length 2, (Required)",
        "example": 90
    },
    "image": {
        "type": "encode base64",
        "description": "Gambar film",
        "example": "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"
    }
}
```

##### Example Response Success

```json
{
    "response": true,
    "message": "Movie created successfully",
    "details": {
        "title": "Oppenheimer",
        "description": "Oppenheimer adalah film biografi sejarah Amerika Serikat tahun 2023 yang disutradarai oleh Christopher Nolan dan diproduseri oleh Christopher Nolan, Emma Thomas dan Charles Roven.",
        "rating": 9,
        "image": "64b985958d589.JPG",
        "updated_at": "2023-07-20 19:05:57",
        "created_at": "2023-07-20 19:05:57",
        "id": 10
    }
}
```

##### Example Response Failed

```json
{
    "response": false,
    "message": "Invalid request data",
    "details": {
        "title": ["The title field is required."],
        "rating": ["The rating field must be a number."]
    }
}
```

#### - Merubah data film

```http
  PUT /movies/${id}
```

| Parameter | Type      | Description                             |
| :-------- | :-------- | :-------------------------------------- |
| `id`      | `integer` | **Required**. Id film yang ingin diubah |

##### Header

```
Content-Type: application/json
```

##### Body

```json
{
    "title": {
        "type": "string",
        "description": "Nama film, Length 255",
        "example": "Oppenheimer"
    },
    "description": {
        "type": "text",
        "description": "Deskripsi film",
        "example": "Oppenheimer adalah film biografi sejarah Amerika Serikat tahun 2023 yang disutradarai oleh Christopher Nolan dan diproduseri oleh Christopher Nolan, Emma Thomas dan Charles Roven."
    },
    "rating": {
        "type": "float",
        "description": "Rating film, Length 2",
        "example": 90
    },
    "image": {
        "type": "encode base64",
        "description": "Gambar film",
        "example": "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"
    }
}
```

##### Example Response Success

```json
{
    "response": true,
    "message": "Movie updated successfully",
    "details": {
        "id": 10,
        "title": "Oppenheimer1",
        "description": "Oppenheimer adalah film biografi sejarah Amerika Serikat tahun 2023 yang disutradarai oleh Christopher Nolan dan diproduseri oleh Christopher Nolan, Emma Thomas dan Charles Roven.1",
        "rating": 9.1,
        "image": "64b985958d589.JPG",
        "created_at": "2023-07-20 19:05:57",
        "updated_at": "2023-07-20 19:06:55"
    }
}
```

##### Example Response Failed

```json
{
    "response": false,
    "message": "Image cannot be created",
    "details": "Unable to init from given binary data."
}
```

#### - Menghapus salah satu film

```http
  DELETE /movies/${id}
```

| Parameter | Type      | Description                              |
| :-------- | :-------- | :--------------------------------------- |
| `id`      | `integer` | **Required**. Id film yang ingin dihapus |

##### Example Response Success

```json
{
    "response": true,
    "message": "Movie deleted successfully",
    "details": {
        "id": 10,
        "title": "Oppenheimer1",
        "description": "Oppenheimer adalah film biografi sejarah Amerika Serikat tahun 2023 yang disutradarai oleh Christopher Nolan dan diproduseri oleh Christopher Nolan, Emma Thomas dan Charles Roven.1",
        "rating": 9.1,
        "image": "64b985958d589.JPG",
        "created_at": "2023-07-20 19:05:57",
        "updated_at": "2023-07-20 19:06:55"
    }
}
```

##### Example Response Failed

```json
{
    "response": false,
    "message": "Movie not found"
}
```

## Running Tests

Untuk menjalankan unit testing, bisa menggunakan command dibawah

```bash
  php artisan test --filter MoviesControllerTest
```

## Documentation

[Postman](https://documenter.getpostman.com/view/10244905/2s946k5q6c)
