# ⚡ Quick Start Guide - TALL Stack

**Branch:** `feature/tall-stack-frontend-improvement`

---

## 🚀 5 Menit Setup

### Step 1: Install Dependencies
```bash
# Install Alpine.js
npm install alpinejs @alpinejs/intersect @alpinejs/focus

# Install Livewire
composer require livewire/livewire
php artisan livewire:publish --config
php artisan livewire:publish --assets
```

### Step 2: Update `resources/js/app.js`
```javascript
import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'
import focus from '@alpinejs/focus'
import './alpine-components'

Alpine.plugin(intersect)
Alpine.plugin(focus)

Alpine.start()
```

### Step 3: Update `resources/css/app.css`
```css
@import './animations.css';
```

### Step 4: Update `resources/views/layouts/app.blade.php`
```blade
<!DOCTYPE html>
<html>
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    <!-- content -->
    
    @livewireScripts
</body>
</html>
```

### Step 5: Build & Test
```bash
npm run build
php artisan serve
```

---

## 📦 Apa yang Sudah Ada

### Alpine.js Components (12 buah)
```html
<!-- Navigation -->
<div x-data="navigation()">
    <button @click="toggleMobileMenu()">Menu</button>
</div>

<!-- Modal -->
<div x-data="modal()">
    <button @click="openModal('Title', 'Content')">Open</button>
</div>

<!-- Form Validation -->
<div x-data="formValidation()">
    <input @blur="validateField('email', $el.value, [{type: 'email'}])">
</div>

<!-- Toast -->
<div x-data="toast()">
    <button @click="show('Success!', 'success')">Show Toast</button>
</div>
```

### Blade Components (3 buah)
```blade
<!-- Modal -->
<x-modal>Content</x-modal>

<!-- Toast -->
<x-toast />

<!-- Skeleton Loader -->
<x-skeleton-loader type="card" count="3" />
```

### Livewire Components (3 buah)
```blade
<!-- Live Search Berita -->
<livewire:berita-search />

<!-- Live Status Checker -->
<livewire:status-checker />

<!-- Live Contact Form -->
<livewire:contact-form />
```

### Animations (20+ buah)
```html
<!-- Fade In -->
<div class="animate-fade-in">Content</div>

<!-- Fade In Up -->
<div class="animate-fade-in-up">Content</div>

<!-- Card Hover -->
<div class="card-hover">Card</div>

<!-- Button Hover -->
<button class="btn-hover-lift">Button</button>
```

---

## 🎯 Common Use Cases

### 1. Add Scroll Animation
```html
<div x-data="{ shown: false }" 
     x-intersect="shown = true"
     x-show="shown"
     x-transition.duration.500ms
     class="animate-fade-in-up">
    Content
</div>
```

### 2. Add Modal
```blade
<button @click="$dispatch('openModal', { title: 'Confirm', content: 'Are you sure?' })">
    Delete
</button>

<x-modal />
```

### 3. Add Toast Notification
```blade
<x-toast />

<button @click="$dispatch('toast', { message: 'Success!', type: 'success' })">
    Submit
</button>
```

### 4. Add Live Search
```blade
<livewire:berita-search />
```

### 5. Add Form Validation
```html
<div x-data="formValidation()">
    <input 
        @blur="validateField('email', $el.value, [{type: 'email', message: 'Invalid email'}])"
        @change="markTouched('email')"
        :class="{ 'border-red-500': hasError('email') }">
    <span x-show="hasError('email')" x-text="getError('email')"></span>
</div>
```

---

## 📁 File Locations

| File | Location | Purpose |
|------|----------|---------|
| Alpine Components | `resources/js/alpine-components.js` | 12 reusable components |
| Animations | `resources/css/animations.css` | 20+ animations |
| Modal | `resources/views/components/modal.blade.php` | Modal dialog |
| Toast | `resources/views/components/toast.blade.php` | Notifications |
| Skeleton | `resources/views/components/skeleton-loader.blade.php` | Loading state |
| BeritaSearch | `app/Livewire/BeritaSearch.php` | Live search |
| StatusChecker | `app/Livewire/StatusChecker.php` | Status tracking |
| ContactForm | `app/Livewire/ContactForm.php` | Contact form |

---

## 🧪 Testing

### Test Alpine.js
```javascript
// Open browser console
console.log(Alpine)
```

### Test Livewire
```javascript
// Open browser console
console.log(Livewire)
```

### Test Animations
```html
<div class="animate-fade-in">Should fade in</div>
<div class="card-hover">Hover me</div>
```

---

## 🐛 Common Issues

### Issue: Alpine.js not working
**Solution:**
1. Run `npm run build`
2. Check browser console for errors
3. Verify Alpine import in `app.js`

### Issue: Livewire not working
**Solution:**
1. Run `composer require livewire/livewire`
2. Check `@livewireStyles` and `@livewireScripts` in layout
3. Run `php artisan cache:clear`

### Issue: Animations not smooth
**Solution:**
1. Check browser performance
2. Reduce animation duration
3. Test on different device

---

## 📚 Documentation

- **Full Guide:** `TALL_STACK_IMPLEMENTATION_SUMMARY.md`
- **Setup Guide:** `TALL_STACK_SETUP.md`
- **Progress:** `IMPLEMENTATION_PROGRESS.md`
- **Issues:** `ISSUE.md`

---

## 🎨 Animation Classes

```css
/* Fade */
.animate-fade-in
.animate-fade-in-up
.animate-fade-in-down
.animate-fade-in-left
.animate-fade-in-right

/* Scale */
.animate-scale-in

/* Slide */
.animate-slide-in-left
.animate-slide-out-left

/* Effects */
.animate-bounce-light
.animate-spin-slow
.animate-pulse-light

/* Hover */
.card-hover
.btn-hover-lift
.btn-hover-scale
.link-hover-underline

/* Loading */
.skeleton
.spinner
.progress-bar
```

---

## 🚀 Next Steps

1. ✅ Install dependencies
2. ✅ Update layout files
3. ✅ Build assets
4. ⏭️ Replace existing views dengan Livewire components
5. ⏭️ Add scroll animations
6. ⏭️ Test & optimize

---

**Ready to go!** 🎉

For more details, see `TALL_STACK_IMPLEMENTATION_SUMMARY.md`
