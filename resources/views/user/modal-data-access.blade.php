<!-- resources/views/menu/modal-data.blade.php -->
<div id="modal-data-access-role"
     class="fixed inset-0 hidden z-50 flex items-center justify-center bg-gray-800 bg-opacity-40 backdrop-blur-sm">

    <!-- Modal Box -->
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-3lg mx-4 animate-fadeIn relative 
            max-h-[90vh] overflow-y-auto">
        <!-- Header -->
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h5 id="modal-title" class="text-lg font-semibold text-gray-800">
                FORM AKSES ROLE
            </h5>
            <button id="close-modal"
                    class="absolute top-4 right-5 text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-4">
            <form id="form-data">
                @csrf

                <!-- Dropdown Role -->
                <div class="flex items-center gap-4">
                    <h6 class="text-sm font-medium text-gray-700">Roles Name: </h6>
                    <h6 class="text-sm font-medium text-gray-700" id="rolesName"></h6>
                    <input type="hidden" id="idRoles">
                </div>

                <!-- Tabel Hak Akses -->
                <div class="mt-4 overflow-x-auto border rounded-lg shadow-sm">
                    <table class="min-w-full text-sm text-left border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 w-1/3">Nama Menu</th>
                                <th class="px-4 py-2 text-center">View</th>
                                <th class="px-4 py-2 text-center">Create</th>
                                <th class="px-4 py-2 text-center">Edit</th>
                                <th class="px-4 py-2 text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($menus as $parent)

                                {{-- PARENT MENU --}}
                                <tr class="bg-gray-50">
                                    <td colspan="5" class="font-semibold text-gray-700 px-4 py-2">
                                        📁 {{ $parent->menuname }}
                                    </td>
                                </tr>

                                {{-- CHILD MENU --}}
                                @foreach ($parent->children as $menu)
                                    @php
                                        $akses = $menu->roles->first()?->pivot;
                                    @endphp

                                    <tr>
                                        <td class="px-4 py-2 pl-6">— {{ $menu->menuname }}</td>

                                        <td class="text-center">
                                            <input type="checkbox"
                                                name="akses[{{ $menu->id }}][view]"
                                                {{ $akses?->can_view ? 'checked' : '' }}>
                                        </td>

                                        <td class="text-center">
                                            <input type="checkbox"
                                                name="akses[{{ $menu->id }}][create]"
                                                {{ $akses?->can_create ? 'checked' : '' }}>
                                        </td>

                                        <td class="text-center">
                                            <input type="checkbox"
                                                name="akses[{{ $menu->id }}][edit]"
                                                {{ $akses?->can_edit ? 'checked' : '' }}>
                                        </td>

                                        <td class="text-center">
                                            <input type="checkbox"
                                                name="akses[{{ $menu->id }}][delete]"
                                                {{ $akses?->can_delete ? 'checked' : '' }}>
                                        </td>
                                    </tr>
                                @endforeach

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="flex justify-end gap-2 border-t px-6 py-4 bg-gray-50 rounded-b-xl">
            <button type="button" id="cancel-modal"
                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                Close
            </button>
            <button type="button" id="btn-simpan"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            </button>
            <button type="button" id="btn-update"
                class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
            </button>
        </div>
    </div>
</div>

<!-- Animasi -->
<style>
@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.95); }
  to   { opacity: 1; transform: scale(1); }
}
.animate-fadeIn {
  animation: fadeIn 0.25s ease-out;
}
</style>

<!-- Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modal-data-access-role');
    const closeModalBtn = document.getElementById('close-modal');
    const cancelBtn = document.getElementById('cancel-modal');

    // buka modal
    window.showModal = function (title = 'FORM INPUT MENU', data = null) {
        document.getElementById('modal-title').innerText = title;
        document.getElementById('form-data').reset();
        modal.classList.remove('hidden');
    };

    // tutup modal
    const closeModal = () => modal.classList.add('hidden');
    closeModalBtn?.addEventListener('click', closeModal);
    cancelBtn?.addEventListener('click', closeModal);
});
</script>
