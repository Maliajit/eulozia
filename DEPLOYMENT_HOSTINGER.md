# Deployment on Hostinger Shared Hosting

## Storage Configuration

Your application is now configured to use **local storage** on your Hostinger server using your 50GB available space.

### How it Works

1. **Files are stored** in: `~/domains/eulozia.com/eulozia/storage/app/private/`
2. **Files are served** via: `https://eulozia.com/storage/{path}`
3. **No symlinks needed** - routes automatically serve files

### File Structure

Files are organized by type:
- Brands logos: `brands/logos/YYYY/MM/filename.jpg`
- Product images: `products/media/YYYY/MM/filename.jpg`

## Deployment Checklist

### 1. On Your Server (via SSH)

```bash
cd ~/domains/eulozia.com/eulozia

# Set proper permissions for storage directory
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Clear caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ensure app key is set
php artisan key:generate

# Run migrations (if fresh install)
php artisan migrate --force

# Seed database (if needed)
php artisan db:seed
```

### 2. Configure .env

SSH into server and edit `.env`:

```bash
nano ~/domains/eulozia.com/eulozia/.env
```

Make sure these settings are correct:

```env
APP_NAME=Eulozia
APP_ENV=production
APP_DEBUG=false
APP_URL=https://eulozia.com

FILESYSTEM_DISK=local

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 3. Update index.php

The main entry point is at `~/domains/eulozia.com/public_html/index.php`

Make sure it points to the correct paths:

```php
require __DIR__.'/../eulozia/vendor/autoload.php';
$app = require_once __DIR__.'/../eulozia/bootstrap/app.php';
```

### 4. Verify File Serving

Test file uploads:
1. Login to admin panel
2. Upload a brand logo or product image
3. Check if file appears in the product listing
4. Verify URL works: `https://eulozia.com/storage/brands/logos/...`

## How Files are Served

When you upload a file:

1. **Upload**: File → `storage/app/private/brands/logos/YYYY/MM/file.jpg`
2. **Database**: Path stored in media table: `brands/logos/YYYY/MM/file.jpg`
3. **Display**: URL generated via `Storage::url()` → `/storage/brands/logos/YYYY/MM/file.jpg`
4. **Route**: Custom route serves file → Laravel returns file content

## Troubleshooting

### Images Not Showing

Check permissions:
```bash
cd ~/domains/eulozia.com/eulozia
ls -la storage/app/private/
```

Should show: `drwxrwxr-x` (755 or 775)

If not:
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Storage Permissions

If uploads fail, check directory is writable:

```bash
touch ~/domains/eulozia.com/eulozia/storage/app/private/test.txt
rm ~/domains/eulozia.com/eulozia/storage/app/private/test.txt
```

### Clear Storage Cache

```bash
php artisan config:cache
php artisan route:cache
```

## Storage Limits

- **Total Available**: 50 GB
- **Recommended Usage**: 40 GB (leave 10 GB buffer)
- **Monitor via**: File Manager in Hostinger hPanel

## Backup Strategy

Regularly backup storage directory:

```bash
# From your local machine
scp -P 65002 -r u222733993@145.79.211.230:~/domains/eulozia.com/eulozia/storage/app/private ./backups/
```

## Important Notes

- ✅ No AWS needed
- ✅ No additional costs
- ✅ Uses your existing 50GB quota
- ✅ No symlinks required
- ✅ Files automatically accessible via routes
- ⚠️ Monitor disk usage growth
- ⚠️ Implement automated backups
