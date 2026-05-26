{{-- Skeleton Loader Component --}}
@props(['type' => 'card', 'count' => 1])

@if ($type === 'card')
    @for ($i = 0; $i < $count; $i++)
        <div class="bg-white rounded-lg shadow p-6 mb-4">
            {{-- Image Skeleton --}}
            <div class="skeleton h-48 w-full rounded-lg mb-4"></div>

            {{-- Title Skeleton --}}
            <div class="skeleton h-6 w-3/4 rounded mb-3"></div>

            {{-- Text Skeleton --}}
            <div class="space-y-2 mb-4">
                <div class="skeleton h-4 w-full rounded"></div>
                <div class="skeleton h-4 w-5/6 rounded"></div>
            </div>

            {{-- Button Skeleton --}}
            <div class="skeleton h-10 w-24 rounded"></div>
        </div>
    @endfor
@elseif ($type === 'list')
    @for ($i = 0; $i < $count; $i++)
        <div class="flex items-center gap-4 p-4 border-b border-gray-200">
            {{-- Avatar Skeleton --}}
            <div class="skeleton h-12 w-12 rounded-full flex-shrink-0"></div>

            {{-- Content Skeleton --}}
            <div class="flex-1">
                <div class="skeleton h-4 w-1/3 rounded mb-2"></div>
                <div class="skeleton h-3 w-1/2 rounded"></div>
            </div>
        </div>
    @endfor
@elseif ($type === 'table')
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-200">
                @for ($j = 0; $j < 4; $j++)
                    <th class="px-4 py-3 text-left">
                        <div class="skeleton h-4 w-20 rounded"></div>
                    </th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < $count; $i++)
                <tr class="border-b border-gray-200">
                    @for ($j = 0; $j < 4; $j++)
                        <td class="px-4 py-3">
                            <div class="skeleton h-4 w-24 rounded"></div>
                        </td>
                    @endfor
                </tr>
            @endfor
        </tbody>
    </table>
@elseif ($type === 'text')
    <div class="space-y-3">
        @for ($i = 0; $i < $count; $i++)
            <div class="skeleton h-4 w-full rounded"></div>
        @endfor
    </div>
@endif

{{-- Usage Examples:

    {{-- Card Skeleton --}}
    <x-skeleton-loader type="card" count="3" />

    {{-- List Skeleton --}}
    <x-skeleton-loader type="list" count="5" />

    {{-- Table Skeleton --}}
    <x-skeleton-loader type="table" count="4" />

    {{-- Text Skeleton --}}
    <x-skeleton-loader type="text" count="3" />
--}}
