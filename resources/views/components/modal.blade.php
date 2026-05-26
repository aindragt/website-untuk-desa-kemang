{{-- Modal Component --}}
<div x-data="modal()"
     @keydown.escape="closeModal()"
     class="fixed inset-0 z-50 flex items-center justify-center"
     :class="{ 'hidden': !open }">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity"
         @click="closeModal()"
         x-show="open"
         x-transition.opacity></div>

    {{-- Modal Content --}}
    <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-4 z-10"
         x-show="open"
         x-transition.scale.origin.center
         @click.stop>

        {{-- Header --}}
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900" x-text="title"></h3>
            <button @click="closeModal()"
                    class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="p-6">
            {{ $slot }}
        </div>

        {{-- Footer (optional) --}}
        @if (isset($footer))
            <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
