# 🚀 TALL Stack Setup Guide

## Prerequisites
Pastikan sudah terinstall:
- PHP 8.3+
- Composer
- Node.js 18+ (untuk npm)
- Git

## Installation Steps

### 1. Install Node.js (jika belum)
Download dari: https://nodejs.org/ (LTS version)

### 2. Install Alpine.js & Plugins
```bash
npm install alpinejs @alpinejs/intersect @alpinejs/focus
```

### 3. Install Livewire
```bash
composer require livewire/livewire
php artisan livewire:publish --config
php artisan livewire:publish --assets
```

### 4. Update app.js
File: `resources/js/app.js`
```javascript
import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'
import focus from '@alpinejs/focus'

Alpine.plugin(intersect)
Alpine.plugin(focus)

Alpine.start()
```

### 5. Update Layout
File: `resources/views/layouts/app.blade.php`
```blade
@livewireStyles
<!-- existing content -->
@livewireScripts
```

### 6. Build Assets
```bash
npm run build
```

## Verification
- [ ] Alpine.js loaded (check browser console)
- [ ] Livewire loaded (check browser console)
- [ ] No JavaScript errors
- [ ] Animations working

## Next Steps
Lihat ISSUE.md untuk task breakdown
