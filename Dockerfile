# Gunakan image PHP versi 8.2 yang ringan
FROM php:8.2-cli

# Install system dependencies, Node.js (untuk Vite), dan PostgreSQL extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    nodejs \
    npm

# Bersihkan cache instalasi
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install ekstensi PHP yang dibutuhkan Laravel dan PostgreSQL
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set direktori kerja di dalam container
WORKDIR /app

# Copy seluruh file project ke dalam container
COPY . /app

# Install dependency Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Install dependency Vue/React/Tailwind dan Build aset
RUN npm install
RUN npm run build

# Beri hak akses (permission) ke folder storage dan cache
RUN chmod -R 777 storage bootstrap/cache

# Buka port 8000 agar Koyeb bisa mengaksesnya
EXPOSE 8000

# Saat server menyala, jalankan perintah migrate otomatis lalu nyalakan web
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
