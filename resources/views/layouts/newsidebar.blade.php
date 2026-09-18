<!-- Dashboard -->
<!-- <a href=""
   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-ink transition">
    <span class="material-icons-outlined text-[18px] text-slate-400">dashboard</span> Dashboard
</a> -->

<!-- Menu Dinamis -->
@auth
    @foreach($menus as $menu)
        <div x-data="{ open: false }" class="mb-0.5">
            {{-- Jika menu punya submenu --}}
            @if($menu->children->count() > 0)
                <button @click="open = !open"
                        class="w-full flex items-center justify-between gap-3 px-3 py-2 rounded-lg text-sm font-medium transition"
                        :class="open ? 'bg-accent-bg text-accent font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-ink'">

                    <span class="flex items-center gap-3">

                        {{-- Icon Bootstrap dari database --}}
                        <i class="bi {{ $menu->icon }} text-[18px]"
                        :class="open ? 'text-accent' : 'text-slate-400'"></i>

                        {{-- Nama Menu --}}
                        {{ $menu->menuname }}

                    </span>

                    <svg class="w-4 h-4 text-slate-400 transform transition-transform duration-300"
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
                    class="pl-9 mt-0.5 space-y-0.5 overflow-hidden">

                    @foreach($menu->children as $child)
                        <a href="{{ route($child->route) }}"
                        class="flex items-center gap-2 pr-3 py-2 rounded-lg text-[13px] font-medium text-slate-600 hover:bg-slate-50 hover:text-ink transition">

                            {{-- Icon submenu --}}
                            <i class="bi {{ $child->icon ?? 'bi-dot' }} text-slate-400"></i>

                            {{-- Nama Submenu --}}
                            {{ $child->menuname }}

                        </a>
                    @endforeach
                </div>

            @else
                {{-- Menu tanpa submenu --}}
                <a href="{{ route($menu->route) }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-ink transition">

                    {{-- Icon Bootstrap dari database --}}
                    <i class="bi {{ $menu->icon }} text-[18px] text-slate-400"></i>

                    {{-- Nama Menu --}}
                    {{ $menu->menuname }}

                </a>
            @endif
        </div>
    @endforeach
@endauth