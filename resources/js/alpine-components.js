/**
 * Alpine.js Components
 * Reusable Alpine.js components untuk TALL Stack
 */

import Alpine from 'alpinejs'

// ============================================================
// 1. SCROLL ANIMATIONS
// ============================================================

/**
 * Scroll Animation Component
 * Menampilkan elemen dengan animasi saat masuk viewport
 */
Alpine.data('scrollAnimation', () => ({
    shown: false,
    init() {
        // Alpine.js akan handle dengan x-intersect directive
    }
}))

// ============================================================
// 2. NAVIGATION MENU
// ============================================================

/**
 * Navigation Component
 * Dropdown menu dan mobile hamburger menu
 */
Alpine.data('navigation', () => ({
    mobileMenuOpen: false,
    activeDropdown: null,

    toggleMobileMenu() {
        this.mobileMenuOpen = !this.mobileMenuOpen
    },

    closeMobileMenu() {
        this.mobileMenuOpen = false
    },

    toggleDropdown(name) {
        this.activeDropdown = this.activeDropdown === name ? null : name
    },

    closeDropdown() {
        this.activeDropdown = null
    }
}))

// ============================================================
// 3. MODAL COMPONENT
// ============================================================

/**
 * Modal Component
 * Reusable modal dialog
 */
Alpine.data('modal', () => ({
    open: false,
    title: '',
    content: '',

    openModal(title = '', content = '') {
        this.title = title
        this.content = content
        this.open = true
        document.body.style.overflow = 'hidden'
    },

    closeModal() {
        this.open = false
        document.body.style.overflow = 'auto'
    },

    handleEscape(e) {
        if (e.key === 'Escape') {
            this.closeModal()
        }
    }
}))

// ============================================================
// 4. FORM VALIDATION
// ============================================================

/**
 * Form Validation Component
 * Real-time form validation dengan feedback
 */
Alpine.data('formValidation', () => ({
    errors: {},
    touched: {},

    validateField(fieldName, value, rules) {
        let error = null

        for (let rule of rules) {
            if (rule.type === 'required' && !value) {
                error = rule.message || 'Field ini wajib diisi'
                break
            }

            if (rule.type === 'email' && value && !this.isValidEmail(value)) {
                error = rule.message || 'Email tidak valid'
                break
            }

            if (rule.type === 'minLength' && value && value.length < rule.value) {
                error = rule.message || `Minimal ${rule.value} karakter`
                break
            }

            if (rule.type === 'maxLength' && value && value.length > rule.value) {
                error = rule.message || `Maksimal ${rule.value} karakter`
                break
            }

            if (rule.type === 'pattern' && value && !rule.value.test(value)) {
                error = rule.message || 'Format tidak valid'
                break
            }
        }

        if (error) {
            this.errors[fieldName] = error
        } else {
            delete this.errors[fieldName]
        }

        return !error
    },

    isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
        return re.test(email)
    },

    markTouched(fieldName) {
        this.touched[fieldName] = true
    },

    hasError(fieldName) {
        return this.touched[fieldName] && this.errors[fieldName]
    },

    getError(fieldName) {
        return this.errors[fieldName] || ''
    }
}))

// ============================================================
// 5. CHARACTER COUNTER
// ============================================================

/**
 * Character Counter Component
 * Menampilkan jumlah karakter yang diketik
 */
Alpine.data('characterCounter', () => ({
    count: 0,
    maxLength: 0,

    updateCount(value, max) {
        this.count = value.length
        this.maxLength = max
    },

    getPercentage() {
        return Math.round((this.count / this.maxLength) * 100)
    },

    isNearLimit() {
        return this.getPercentage() >= 80
    }
}))

// ============================================================
// 6. TOAST NOTIFICATION
// ============================================================

/**
 * Toast Notification Component
 * Menampilkan notifikasi temporary
 */
Alpine.data('toast', () => ({
    visible: false,
    message: '',
    type: 'info', // success, error, warning, info
    duration: 3000,

    show(message, type = 'info', duration = 3000) {
        this.message = message
        this.type = type
        this.visible = true

        setTimeout(() => {
            this.visible = false
        }, duration)
    },

    getIcon() {
        const icons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ℹ'
        }
        return icons[this.type] || icons.info
    },

    getColor() {
        const colors = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            warning: 'bg-yellow-500',
            info: 'bg-blue-500'
        }
        return colors[this.type] || colors.info
    }
}))

// ============================================================
// 7. ACCORDION COMPONENT
// ============================================================

/**
 * Accordion Component
 * Expandable accordion items
 */
Alpine.data('accordion', () => ({
    activeItem: null,
    allowMultiple: false,

    toggleItem(itemId) {
        if (this.allowMultiple) {
            // Multiple items bisa terbuka
            if (this.activeItem === itemId) {
                this.activeItem = null
            } else {
                this.activeItem = itemId
            }
        } else {
            // Hanya satu item yang bisa terbuka
            this.activeItem = this.activeItem === itemId ? null : itemId
        }
    },

    isOpen(itemId) {
        return this.activeItem === itemId
    }
}))

// ============================================================
// 8. TABS COMPONENT
// ============================================================

/**
 * Tabs Component
 * Tab navigation dengan content switching
 */
Alpine.data('tabs', () => ({
    activeTab: 0,

    setActiveTab(index) {
        this.activeTab = index
    },

    isActive(index) {
        return this.activeTab === index
    }
}))

// ============================================================
// 9. DROPDOWN COMPONENT
// ============================================================

/**
 * Dropdown Component
 * Reusable dropdown menu
 */
Alpine.data('dropdown', () => ({
    open: false,

    toggle() {
        this.open = !this.open
    },

    close() {
        this.open = false
    },

    handleClickOutside(e) {
        if (!this.$el.contains(e.target)) {
            this.close()
        }
    }
}))

// ============================================================
// 10. LOADING STATE
// ============================================================

/**
 * Loading State Component
 * Menampilkan loading indicator
 */
Alpine.data('loadingState', () => ({
    loading: false,

    startLoading() {
        this.loading = true
    },

    stopLoading() {
        this.loading = false
    }
}))

// ============================================================
// 11. SCROLL PROGRESS BAR
// ============================================================

/**
 * Scroll Progress Bar
 * Menampilkan progress bar saat scroll
 */
Alpine.data('scrollProgress', () => ({
    progress: 0,

    init() {
        window.addEventListener('scroll', () => {
            const scrollTop = window.scrollY
            const docHeight = document.documentElement.scrollHeight - window.innerHeight
            const scrollPercent = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0
            this.progress = scrollPercent
        })
    }
}))

// ============================================================
// 12. AUTO-SAVE FORM
// ============================================================

/**
 * Auto-Save Component
 * Menyimpan form data ke localStorage secara otomatis
 */
Alpine.data('autoSave', () => ({
    formKey: '',
    saveInterval: 5000,
    lastSaved: null,

    init() {
        // Load dari localStorage jika ada
        const saved = localStorage.getItem(this.formKey)
        if (saved) {
            this.restoreForm(JSON.parse(saved))
        }

        // Auto-save setiap interval
        setInterval(() => {
            this.saveForm()
        }, this.saveInterval)
    },

    saveForm() {
        const formData = new FormData(this.$el)
        const data = Object.fromEntries(formData)
        localStorage.setItem(this.formKey, JSON.stringify(data))
        this.lastSaved = new Date()
    },

    restoreForm(data) {
        Object.keys(data).forEach(key => {
            const field = this.$el.querySelector(`[name="${key}"]`)
            if (field) {
                field.value = data[key]
            }
        })
    },

    clearSavedData() {
        localStorage.removeItem(this.formKey)
    }
}))

export default Alpine
