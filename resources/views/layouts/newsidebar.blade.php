<!-- Dashboard -->
<!-- <a href="" 
   class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-200 transition">
    <span class="material-icons-outlined mr-3">dashboard</span> Dashboard
</a> -->

<!-- Menu Dinamis -->
@auth
    @foreach($menus as $menu)
        <div x-data="{ open: false }" class="mb-1">
            {{-- Jika menu punya submenu --}}
            @if($menu->children->count() > 0)
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                    <div class="flex items-center">
                        <span class="material-icons-outlined mr-3">{{ $menu->icon }}</span>
                        {{ $menu->menuname }}
                    </div>
                    <svg class="w-4 h-4 transform transition-transform duration-300" 
                         :class="{ 'rotate-180': open }"
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Submenu dengan animasi buka/tutup --}}
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="pl-11 mt-1 space-y-1 overflow-hidden">
                    @foreach($menu->children as $child)
                        <a href="{{ route($child->route) }}" 
                           class="block py-1 px-2 rounded hover:bg-gray-200 transition">
                           {{ $child->menuname }}
                        </a>
                    @endforeach
                </div>
            @else
                {{-- Menu tanpa submenu --}}
                <a href="{{ route($menu->route) }}" 
                   class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                    <span class="material-icons-outlined mr-3">{{ $menu->icon }}</span>
                    {{ $menu->menuname }}
                </a>
            @endif
        </div>
    @endforeach
@endauth