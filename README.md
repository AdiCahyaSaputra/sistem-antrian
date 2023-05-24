# Sistem Antrian

## Run On Your Local Machine
```
# Clone Repo
git clone https://github.com/AdiCahyaSaputra/sistem-antrian
cd sistem-antrian

# Install Dependencies
composer install
npm install

# Setup Laravel .env
cp -r .env.example .env
php artisan key:generate

# Migration (Don't forget to fill the database credentials in .env first)
php artisan migrate:fresh --seed

# Setup API Authentication from play.ht to your .env
# AUTHORIZATION='YOUR_SECRET_KEY'
# USER_ID='YOUR_USER_ID'

# Link storage to public folder (add 'FILESYSTEM_DISK=public' at your .env) and
php artisan storage:link

# Run APP
php artisan ser
npm run dev
```

## People Behind This Project
- [AdiCahyaSaputra](https://github.com/AdiCahyaSaputra)
- [MuhammadRisky](https://github.com/dante-heisenberg)

## Reference
- [API Access play.ht](https://play.ht/app/api-access)
- [API Docs play.ht](https://docs.play.ht/reference/api-getting-started)
- [Error Tracking (sentry)](https://docs.sentry.io/platforms/php/guides/laravel/)

## Todo
- [x] Text To Speech API  
- [x] Daftar Antrian  
- [x] Kelola Antrian (admin/op)  
- [x] Kelola Antrian Bendahara (admin/op)  
- [ ] Display Antrian  
- [ ] Laporan per hari    
