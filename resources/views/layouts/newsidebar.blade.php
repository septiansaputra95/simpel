<!-- Dashboard -->
<a href="#" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-200 transition">
    <span class="material-icons-outlined mr-3">dashboard</span> Dashboard
</a>

<!-- Users with sub-menu -->
@hasanyrole('admin')
<div>
    <button onclick="toggleSubmenu('submenu-users')" 
            class="w-full flex items-center justify-between px-4 py-2 rounded-lg hover:bg-gray-200 transition">
        <div class="flex items-center">
            <span class="material-icons-outlined mr-3">people</span> Users
        </div>
        <svg class="w-4 h-4 transition-transform" id="icon-submenu-users" fill="none" stroke="currentColor" stroke-width="2" 
                viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    <div id="submenu-users" class="hidden pl-11 mt-1 space-y-1">
        <a href="{{ route('user.index') }}" class="block py-1 px-2 rounded hover:bg-gray-200">Daftar Users</a>
        <a href="#" class="block py-1 px-2 rounded hover:bg-gray-200">Hak Akses Users</a>
    </div>
</div>

<!-- Reports with sub-menu -->
<div>
    <button onclick="toggleSubmenu('submenu-reports')" 
            class="w-full flex items-center justify-between px-4 py-2 rounded-lg hover:bg-gray-200 transition">
        <div class="flex items-center">
            <span class="material-icons-outlined mr-3">settings</span> Setting
        </div>
        <svg class="w-4 h-4 transition-transform" id="icon-submenu-reports" fill="none" stroke="currentColor" stroke-width="2" 
                viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    <div id="submenu-reports" class="hidden pl-11 mt-1 space-y-1">
        <a href="#" class="block py-1 px-2 rounded hover:bg-gray-200">Main Menu</a>
        <a href="#" class="block py-1 px-2 rounded hover:bg-gray-200">Sub Menu</a>
    </div>
</div>

@endhasanyrole