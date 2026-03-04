# Usamos la imagen oficial de PHP 8.2 con Apache
FROM php:8.2-apache

# --- INSTALACIÓN DE DEPENDENCIAS Y EXTENSIONES (MÉTODO ROBUSTO) ---
# Combinamos todo en un solo RUN para mayor fiabilidad y para evitar problemas de caché
RUN apt-get update && apt-get install -y \
    # --- Herramientas básicas ---
    git \
    zip \
    unzip \
    curl \
    gnupg \
    # --- Dependencias para extensiones PHP ---
    libpq-dev \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    # --- Instalamos extensiones PHP ---
    && docker-php-ext-install -j$(nproc) pdo pdo_pgsql intl zip \
    # --- Configuramos e instalamos GD ---
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    # --- Limpiamos caché de apt ---
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# --- INSTALACIÓN DE NODE.JS Y NPM ---
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# --- INSTALACIÓN DE COMPOSER ---
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# --- CONFIGURACIÓN DE APACHE Y DIRECTORIO DE TRABAJO ---
WORKDIR /var/www/html

# Apuntamos Apache a la carpeta /public de Laravel
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN a2enmod rewrite
