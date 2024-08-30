<!-- Sidebar Menu Section -->
<div class="menu-item py-2 px-4 cursor-pointer" onclick="toggleSubmenu('inventorySubmenu')">
    <span class="font-semibold text-lg">
        <i class="fas fa-boxes mr-2"></i> Inventory
    </span>
    <div id="inventorySubmenu" class="submenu">
        <div class="submenu-item py-2 px-4 text-gray-300 hover:text-white cursor-pointer">
            <i class="fas fa-box-open mr-2"></i> Permintaan
        </div>
        <div class="submenu-item py-2 px-4 text-gray-300 hover:text-white cursor-pointer">
            <i class="fas fa-dolly mr-2"></i> Pengeluaran
        </div>
    </div>
</div>

<!-- Menu Master -->
<div class="menu-item py-2 px-4 cursor-pointer mt-4" onclick="toggleSubmenu('masterSubmenu')">
    <span class="font-semibold text-lg">
        <i class="fas fa-cogs mr-2"></i> Master
    </span>
    <div id="masterSubmenu" class="submenu">
        <div class="submenu-item py-2 px-4 text-gray-300 hover:text-white cursor-pointer">
            <i class="fas fa-cube mr-2"></i> Barang
        </div>
        <div class="submenu-item py-2 px-4 text-gray-300 hover:text-white cursor-pointer">
            <i class="fas fa-building mr-2"></i> Unit
        </div>
        <div class="submenu-item py-2 px-4 text-gray-300 hover:text-white cursor-pointer">
            <i class="fas fa-ruler mr-2"></i> Satuan
        </div>
    </div>
</div>

<!-- Menu BPJS -->
<div class="menu-item py-2 px-4 cursor-pointer mt-4" onclick="toggleSubmenu('bpjsSubmenu')">
    <span class="font-semibold text-lg">
        <i class="fas fa-notes-medical mr-2"></i> BPJS
    </span>
    <div id="bpjsSubmenu" class="submenu">
        <a href="{{ route('antrianonline.index') }}" class="submenu-item py-2 px-4 text-gray-300 hover:text-white cursor-pointer">
            <i class="fas fa-list-alt mr-2"></i> Antrian Online
        </a>

        <a href="{{ route('tasklist.index') }}" class="submenu-item py-2 px-4 text-gray-300 hover:text-white cursor-pointer">
            <i class="fas fa-list-alt mr-2"></i> Task List
        </a>

        <a href="{{ route('updatetask.index') }}" class="submenu-item py-2 px-4 text-gray-300 hover:text-white cursor-pointer">
            <i class="fas fa-list-alt mr-2"></i> Update Task
        </a>
    </div>
</div>
