$(function () {
    let urlLoadData = "/user/datatables";
    let urlLoadDataRole = "/user/rolesdatatables";
    // let urlAccessRole = "/user/${id}/accessRole";
    let dataTabel = $("#tabel-data");
    let dataTabelRole = $("#tabel-data-role");

    // ROLES
    let modal = $("#modal-data-access-role");
    let modalEl = document.getElementById('modal-data-access-role');

    const urlAccessRole = (id) => `/user/${id}/accessRole`;
    const urlUpdateAccessRole = (id) => `/user/${id}/updateAccessRole`;

    document.onclick = function (event) {
        // Pastikan yang diklik punya class 'tab-btn'
        const target = event.target.closest('.tab-btn');
        if (!target) return; // kalau bukan tab, abaikan

        const tabTarget = target.getAttribute('data-tab');

        // Hilangkan style aktif dari semua tab
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('border-blue-500', 'text-blue-600');
            btn.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700');
        });

        // Tambahkan style aktif ke tombol yang diklik
        target.classList.add('border-blue-500', 'text-blue-600');
        target.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700');

        // Sembunyikan semua tab-content
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));

        // Tampilkan tab yang sesuai
        document.getElementById(tabTarget).classList.remove('hidden');

        // Kalau tab2 dibuka → jalankan DataTables
        if (tabTarget === 'tab2') {
            dataRole();
        }
    };

    document.getElementById("btn-tambah-roles").onclick = () => {
        tambahModal();
        showModal();
        console.log("button tambah");
    };

    const tambahModal =() => {
        $("#btn-simpan").text("Simpan"); // Mengubah text button 
        $("#btn-simpan").show();
        $("#btn-update").hide();
    }

    const editModal =() => {
        $("#btn-update").text("Update"); // Mengubah text button 
        $("#btn-update").show();
        $("#btn-simpan").hide();

    }

    const showModal = (method = "POST") => {     
        modal.removeClass("hidden"); // Buka Modal
    };
    

   $(document).on('click', '.btn-edit', function() {
        const userId = $(this).data('id');
        const username = $(this).data('username');
        const nama = $(this).data('nama');
        const role = $(this).data('role');

        console.log("Edit user:", userId, username, nama, role);

        $('#id').val(userId);
        $('#username').val(username);
        $('#nama').val(nama);
        $('#role').val(role);

        $('#modal-data').removeClass('hidden');
    });

    function editUser (){
        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('btn-edit')) {
                const button = e.target;
                const id = button.dataset.id;
                const username = button.dataset.username;

            }
        });
    }

    function accessRoles (){
        // Cek dulu apakah sudah terdaftar atau belum
        if (window._accessRolesListener) return; // cegah dobel

        document.addEventListener('click', function (e) {
            const button = e.target.closest('.btn-access-role');
            if (!button) return;

            const roleId = button.dataset.id;
            const rolesname = button.dataset.rolesname;
            
            document.getElementById('idRoles').value = roleId;
            document.getElementById('rolesName').innerText = rolesname;

            loadAccessRole(roleId);
            editModal();
            showModal();
        });

        // Tandai listener sudah terdaftar
        window._accessRolesListener = true;
    }

    function loadAccessRole(roleId) {
        axios.get(urlAccessRole(roleId))
            .then(res => {
                // response berupa list menu + hak akses
                renderAccessTable(res.data);
            })
            .catch(err => {
                console.error(err);
                alert('Gagal mengambil data hak akses');
            });
    }
    function renderAccessTable(data) {
        const tbody = document.querySelector('#access-table-body');
        tbody.innerHTML = '';

        let currentParent = null;

        data.forEach(item => {
            if (currentParent !== item.parent) {
                currentParent = item.parent;
                tbody.innerHTML += `
                    <tr class="bg-gray-50">
                        <td colspan="5" class="font-semibold px-4 py-2">
                            📁 ${currentParent}
                        </td>
                    </tr>
                `;
            }

            tbody.innerHTML += `
                <tr>
                    <td class="px-4 py-2 pl-6">— ${item.menuname}</td>
                    <td class="text-center">
                        <input type="checkbox" class="perm-checkbox" data-menu-id="${item.menu_id}" data-type="view" ${item.can_view ? 'checked' : ''}>
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="perm-checkbox" data-menu-id="${item.menu_id}" data-type="create" ${item.can_create ? 'checked' : ''}>
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="perm-checkbox" data-menu-id="${item.menu_id}" data-type="edit" ${item.can_edit ? 'checked' : ''}>
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="perm-checkbox" data-menu-id="${item.menu_id}" data-type="delete" ${item.can_delete ? 'checked' : ''}>
                    </td>
                </tr>
            `;
        });
    }

    document.getElementById('btn-update').addEventListener('click', function () {

        const roleId = document.getElementById('idRoles').value;
        const akses = {};

        document.querySelectorAll('.perm-checkbox').forEach(cb => {
            const menuId = cb.dataset.menuId;
            const type = cb.dataset.type;

            if (!akses[menuId]) {
                akses[menuId] = {
                    view: 0,
                    create: 0,
                    edit: 0,
                    delete: 0
                };
            }

            akses[menuId][type] = cb.checked ? 1 : 0;
        });

        axios.post(urlUpdateAccessRole(roleId), {
            role_id: roleId,
            akses: akses
        })
        .then(res => {
            alert('Hak akses berhasil disimpan');
            document.getElementById('modal-data-access-role').classList.add('hidden');
        })
        .catch(err => {
            console.error(err);
            alert('Gagal menyimpan hak akses');
        });
    });



    const data = () => {
        $("#tabel-data").dataTable({
            Processing: true,
            ServerSide: true,
            paging: true,
            sDom: "<t <'float-end' i><p >>",
            iDisplayLength: 15,
            bDestroy: true,
            autoWidth: false,
            ordering: false,
            oLanguage: {
                sLengthMenu: "_MENU_ ",
                sInfo: "Showing <b>_START_ to _END_</b> of _TOTAL_ entries",
                sSearch: "Search Data : ",
                sZeroRecords: "Tidak ada data",
                sEmptyTable: "Data tidak tersedia",
                sLoadingRecords: '<img src="../../ajax-loader.gif"> Loading...',
            },
            ajax: {
                url: urlLoadData,
                type: "GET",
                data: {
                    
                },
            },
            columns: [
                { mData: "no" },
                { mData: "username" },
                { mData: "nama" },
                { mData: "role" },
                { mData: "action" }
            ],
        });

        dataTabel = $("#tabel-data").DataTable();

        $("#term").keyup(function () {
            dataTabel.search($(this).val()).draw();
            $(".table").removeAttr("style");
        });
    };

    const dataRole = () => {
        // console.log('dataRole');

        $("#tabel-data-role").dataTable({
            Processing: true,
            ServerSide: true,
            paging: true,
            sDom: "<t <'float-end' i><p >>",
            iDisplayLength: 15,
            bDestroy: true,
            autoWidth: false,
            ordering: false,
            oLanguage: {
                sLengthMenu: "_MENU_ ",
                sInfo: "Showing <b>_START_ to _END_</b> of _TOTAL_ entries",
                sSearch: "Search Data : ",
                sZeroRecords: "Tidak ada data",
                sEmptyTable: "Data tidak tersedia",
                sLoadingRecords: '<img src="../../ajax-loader.gif"> Loading...',
            },
            ajax: {
                url: urlLoadDataRole,
                type: "GET",
                data: {
                    
                },
            },
            columns: [
                { mData: "no" },
                { mData: "rolesname" },
                { mData: "description" },
                { mData: "action" }
            ],
        });

        dataTabelRole = $("#tabel-data-role").DataTable();

        $("#term").keyup(function () {
            dataTabelRole.search($(this).val()).draw();
            $(".table").removeAttr("style");
        });
    };

    (() => {
        // console.log('masuk ke user.js');
        data();
        dataRole();
        editUser();
        accessRoles();
    })();
    
});
