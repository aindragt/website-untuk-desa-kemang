{{-- Toast Notification Component --}}
<div x-data="toast()"
     @toast.window="show($event.detail.message, $event.detail.type, $event.detail.duration)"
     class="fixed bottom-4 right-4 z-50">

    {{-- Toast Message --}}
    <div x-show="visible"
         x-transition.opacity.duration.300ms
         :class="getColor()"
         class="flex items-center gap-3 px-4 py-3 rounded-lg text-white shadow-lg">

        {{-- Icon --}}
        <span class="flex-shrink-0 text-lg font-bold" x-text="getIcon()"></span>

        {{-- Message --}}
        <span class="flex-1" x-text="message"></span>

        {{-- Close Button --}}
        <button @click="visible = false"
                class="flex-shrink-0 ml-2 text-white hover:text-gray-200 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

{{-- Usage Example:
    <x-toast />

    // Trigger from JavaScript:
    window.dispatchEvent(new CustomEvent('toast', {
        detail: {
            message: 'Success!',
            type: 'success', // success, error, warning, info
            duration: 3000
        }
    }))

    // Or from Alpine.js:
    @click="$dispatch('toast', { message: 'Hello!', type: 'info' })"
--}}
