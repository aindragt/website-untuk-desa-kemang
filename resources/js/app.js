import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'
import focus from '@alpinejs/focus'
import './alpine-components'

// Register Alpine plugins
Alpine.plugin(intersect)
Alpine.plugin(focus)

// Initialize Alpine
Alpine.start()

// ============================================================
// SCROLL ANIMATIONS
// ============================================================

/**
 * Scroll Animation Handler
 * Menambahkan animasi fade-in saat elemen masuk viewport
 */
document.addEventListener('DOMContentLoaded', () => {
    // Animate hero stats
    const stats = document.querySelectorAll('[data-counter]')
    let hasAnimated = false

    const animateStats = () => {
        if (hasAnimated) return
        hasAnimated = true

        stats.forEach(stat => {
            const target = parseInt(stat.getAttribute('data-counter'))
            const duration = 2000
            const start = Date.now()

            const animate = () => {
                const elapsed = Date.now() - start
                const progress = Math.min(elapsed / duration, 1)
                const current = Math.floor(target * progress)

                stat.textContent = current.toLocaleString('id-ID')

                if (progress < 1) {
                    requestAnimationFrame(animate)
                }
            }

            animate()
        })
    }

    // Trigger animation when stats are visible
    const statsSection = document.querySelector('.hero__stats')
    if (statsSection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateStats()
                    observer.unobserve(entry.target)
                }
            })
        }, { threshold: 0.5 })

        observer.observe(statsSection)
    }

    // Add scroll animations to cards
    const cards = document.querySelectorAll('.berita-card, .profil-card, .lembaga-card')
    const cardObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('animate-fade-in-up')
                }, index * 100)
                cardObserver.unobserve(entry.target)
            }
        })
    }, { threshold: 0.1 })

    cards.forEach(card => {
        cardObserver.observe(card)
    })

    // Parallax effect for hero section
    const hero = document.querySelector('.hero')
    if (hero) {
        window.addEventListener('scroll', () => {
            const scrolled = window.scrollY
            hero.style.backgroundPosition = `center ${scrolled * 0.5}px`
        })
    }
})

// ============================================================
// NAVBAR SCROLL EFFECT
// ============================================================

/**
 * Navbar Enhancement
 * Tambahkan shadow saat scroll
 */
document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.getElementById('navbar')

    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.1)'
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.98)'
            } else {
                navbar.style.boxShadow = 'none'
                navbar.style.backgroundColor = 'transparent'
            }
        })
    }
})

// ============================================================
// SMOOTH SCROLL
// ============================================================

/**
 * Smooth Scroll untuk anchor links
 */
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href')
        if (href === '#') return

        e.preventDefault()
        const target = document.querySelector(href)

        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            })
        }
    })
})

// ============================================================
// PAGE TRANSITIONS
// ============================================================

/**
 * Swup Page Transitions
 * Smooth transitions antar halaman
 */
if (typeof Swup !== 'undefined') {
    const swup = new Swup({
        containers: ['#swup'],
        animationSelector: '[class*="transition-"]',
        skipPopStateHandling: false,
        cache: true,
        preload: true,
        animationDuration: 300
    })

    // Re-initialize Alpine after page transition
    swup.on('contentReplaced', () => {
        Alpine.flushAndStopDeferringMacros()
    })

    // Re-initialize scroll animations after page transition
    swup.on('contentReplaced', () => {
        // Trigger scroll animations for new content
        const cards = document.querySelectorAll('.berita-card, .profil-card, .lembaga-card')
        const cardObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('animate-fade-in-up')
                    }, index * 100)
                    cardObserver.unobserve(entry.target)
                }
            })
        }, { threshold: 0.1 })

        cards.forEach(card => {
            cardObserver.observe(card)
        })
    })
}

// ============================================================
// GLIGHTBOX INITIALIZATION
// ============================================================

/**
 * GLightbox untuk image gallery
 */
if (typeof GLightbox !== 'undefined') {
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true
    })
}

// ============================================================
// FORM ENHANCEMENTS
// ============================================================

/**
 * Form Auto-save
 * Simpan form data ke localStorage
 */
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form[data-autosave]')

    forms.forEach(form => {
        const formKey = form.getAttribute('data-autosave')

        // Load saved data
        const saved = localStorage.getItem(formKey)
        if (saved) {
            const data = JSON.parse(saved)
            Object.keys(data).forEach(key => {
                const field = form.querySelector(`[name="${key}"]`)
                if (field) {
                    field.value = data[key]
                }
            })
        }

        // Auto-save on input
        form.addEventListener('input', () => {
            const formData = new FormData(form)
            const data = Object.fromEntries(formData)
            localStorage.setItem(formKey, JSON.stringify(data))
        })

        // Clear on submit
        form.addEventListener('submit', () => {
            localStorage.removeItem(formKey)
        })
    })
})

// ============================================================
// LOADING STATES
// ============================================================

/**
 * Show loading state on form submit
 */
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form')

    forms.forEach(form => {
        form.addEventListener('submit', function () {
            const submitBtn = this.querySelector('button[type="submit"]')
            if (submitBtn) {
                submitBtn.disabled = true
                submitBtn.style.opacity = '0.6'
                submitBtn.style.cursor = 'not-allowed'
            }
        })
    })
})

// ============================================================
// ACCESSIBILITY
// ============================================================

/**
 * Keyboard navigation support
 */
document.addEventListener('DOMContentLoaded', () => {
    // Close mobile menu on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const navMenu = document.getElementById('navMenu')
            if (navMenu && navMenu.classList.contains('active')) {
                navMenu.classList.remove('active')
            }
        }
    })
})

export default Alpine
