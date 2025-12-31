<!-- Dashboard -->
<!-- <a href="" 
   class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-200 transition">
    <span class="material-icons-outlined mr-3">dashboard</span> Dashboard
</a> -->

<!-- Menu Dinamis -->
@auth
    @foreach($menus as $menu)
        <div>
            {{-- Jika menu punya submenu --}}
            @if($menu->children->count() > 0)
                <button onclick="toggleSubmenu('submenu-{{ $menu->id }}')" 
                        class="w-full flex items-center justify-between px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                    <div class="flex items-center">
                        <span class="material-icons-outlined mr-3">{{ $menu->icon }}</span>
                        {{ $menu->menuname }}
                    </div>
                    <svg class="w-4 h-4 transition-transform" id="icon-submenu-{{ $menu->id }}" fill="none" stroke="currentColor" stroke-width="2" 
                            viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- tampilkan submenu --}}
                <div id="submenu-{{ $menu->id }}" class="hidden pl-11 mt-1 space-y-1">
                    @foreach($menu->children as $child)
                        <a href="{{ route($child->route) }}" 
                           class="block py-1 px-2 rounded hover:bg-gray-200">
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
