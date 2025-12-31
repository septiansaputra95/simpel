<!-- resources/views/menu/modal-data.blade.php -->
<div id="modal-data"
     class="fixed inset-0 hidden z-50 flex items-center justify-center bg-gray-800 bg-opacity-40 backdrop-blur-sm">

    <!-- Modal Box -->
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-4 animate-fadeIn relative 
            max-h-[90vh] overflow-y-auto">
        <!-- Header -->
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h5 id="modal-title" class="text-lg font-semibold text-gray-800">
                FORM INPUT MENU
            </h5>
            <button id="close-modal"
                    class="absolute top-4 right-5 text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-4">
            <form id="form-data">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Menu ID</label>
                    <input type="text" id="id" name="id"
                        class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-2.5" readonly>
                </div>
                <br>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Menu</label>
                    <input type="text" id="menuname" name="menuname"
                        class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <label class="flex items-center gap-1 text-sm text-gray-700">
                        <input type="checkbox" id="is_parent" class="rounded text-blue-600 focus:ring-blue-500">
                        <b>Parent Menu</b>
                    </label>
                </div>
                <br>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Route</label>
                    <input type="text" id="route" name="route"
                        class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-2.5">
                </div>
                <br>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Icon</label>
                    <input type="text" id="icon" name="icon"
                        class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-2.5">
                </div>
                <br>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Parent ID</label>
                    <select id="parent_id" name="parent_id"
                        class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-2.5"
                    >
                    </select>
                    <!-- <input type="text" id="parent_id" name="parent_id" -->
                        <!-- class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-2.5"> -->
                </div>
                <br>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="is_active" name="is_active"
                        class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-2.5"
                    >
                    <option value="1">ACTIVE</option>
                    <option value="0">IN ACTIVE</option>
                    </select>
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
    const modal = document.getElementById('modal-data');
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
