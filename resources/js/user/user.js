$(function () {
    let urlLoadData = "/user/datatables";
    let urlLoadDataRole = "/user/rolesdatatables";
    let urlAccessRole = "/user/${id}/accessRole";

    let dataTabel = $("#tabel-data");
    let dataTabelRole = $("#tabel-data-role");

    // ROLES
    let modal = $("#modal-data-access-role");
    let modalEl = document.getElementById('modal-data-access-role');

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
        showModal();
        console.log("button tambah");
    };

    const showModal = (method = "POST") => {

        $("#btn-simpan").text("Simpan"); // Mengubah text button 
        $("#btn-simpan").show();
        $("#btn-update").text("Update"); // Mengubah text button 
        $("#btn-update").hide();
        
        modal.removeClass("hidden"); // Buka Modal
        return false;

    };
    
    $(document).on('click', '.btn-access-role', function () {
        const id          = $(this).data('id');
        const rolesname   = $(this).data('rolesname');
        const description = $(this).data('description');

        console.log(id, rolesname, description);

        // isi data ke modal
        $('#idRoles').val(id);
        $('#rolesName').text(rolesname);

        accessRole();

        // buka modal (TAILWIND)
        $('#modal-data-access-role').removeClass('hidden');
    });

    const accessRole = () => {
        axios.get(urlAccessRole)
            .then((response) => {
          
            })
            .catch((error) => {
                console.error("Error Saat Get Data Parent: ", error);
                alert("Gagal Mengambil Data Parent");
            });
    }

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
    })();
});
