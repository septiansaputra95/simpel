$(function () {
    let urlLoadData = "/menu/datatables";
    let urlSimpan = "/menu/simpan";
    let urlGetParent = "/menu/getParent";

    // Initisalisasi
    let dataTabel = $("#tabel-data");
    let modal = $("#modal-data");

    let modalEl = document.getElementById('modal-data');
    // let bsModal = bootstrap.Modal.getInstance(modalEl);
   


    let menuname        = document.getElementById('menuname');
    let checkbox        = document.getElementById('is_parent');
    let routeInput      = document.getElementById('route');
    let icon            = document.getElementById('icon');
    let parentSelect    = document.getElementById('parent_id');
    let is_active       = document.getElementById('is_active');

    parentSelect.disabled = false;
    checkbox.checked = false;

    checkbox.addEventListener('change', function() {
        if (this.checked) {
            parentSelect.value = '';
            parentSelect.disabled = true;
            parentSelect.classList.add('bg-gray-100', 'cursor-not-allowed');

            routeInput.value = '';
            routeInput.disabled = true; 
            routeInput.classList.add('bg-gray-100', 'cursor-not-allowed');
        } else {
            parentSelect.disabled = false;
            parentSelect.classList.remove('bg-gray-100', 'cursor-not-allowed');
            
            routeInput.disabled = false; 
            routeInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
        }
    });

    document.getElementById("btn-simpan").onclick = () => {
        simpanData();
    };

    document.getElementById("btn-tambah").onclick = () => {
        showModal();
    };

    const simpanData = () => {
        const menunameValue   = menuname.value;
        const isParentChecked = checkbox.checked;  // untuk checkbox pakai .checked
        const routeValue      = routeInput.value;
        const iconValue       = icon.value;
        const parentIdValue   = parentSelect.value;
        const isActiveValue   = is_active.value

        let modal = $("#modal-data");
        // console.log(modal);
        
        if (!menunameValue) {
            alert("Nama Menu Diisi dong...");
            return; // Menghentikan eksekusi jika input kosong
        }
    
        if (!routeValue) {
            alert("Route nya yang jelas...");
            return;
        }
    
        if (!isParentChecked && !parentIdValue) {
            alert("Ini Sub Menu yang mana...?");
            return;
        }
        
        console.log({
            menunameValue,
            isParentChecked,
            routeValue,
            iconValue,
            parentIdValue
        });
        // return;

        const formData = new FormData();
        formData.append("menuname", menunameValue);
        // formData.append("is_parent", isParentChecked);
        formData.append("route", routeValue);
        formData.append("icon", iconValue);
        formData.append("parent_id", parentIdValue);
        formData.append("is_active", isActiveValue);

        axios
            .post(urlSimpan, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
        .then(response => {
            console.log("Response dari server:", response);
            resetModal();
            hideModal();
    
            loadtable();
            alert(response.data.message);
        })
        .catch(error => {
            console.error("Error saat menyimpan data ", error)
            // alert("Gagal Saat Simpan Data");

            if (error.response) {
                alert(error.response.data.message || "Gagal Saat Simpan Dataaa");
            } else {
                alert("Terjadi kesalahan jaringan");
            }
        })
    }

    const resetModal = () => {
        menuname.value = '';
        routeInput.value = '';
        icon.value = '';
        parentSelect.value = '';
        checkbox.checked = false;
        
        parentSelect.disabled = false;
        routeInput.disabled = false;

        parentSelect.classList.remove('bg-gray-100', 'cursor-not-allowed');
        routeInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
    };

    const showModal = (method = "POST") => {
        loadParent();

        $("#btn-simpan").text("Simpan"); // Mengubah text button 
        $("#btn-simpan").show();
        $("#btn-update").text("Update"); // Mengubah text button 
        $("#btn-update").hide();
        
        modal.removeClass("hidden"); // Buka Modal
        return false;

    };

    function hideModal() {
        modalEl.classList.add('hidden');
    }

    const loadParent = () => {
        axios.get(urlGetParent)
            .then((response) => {
                let data = response.data;
                let select = $('#parent_id');

                // console.log(response.data.data);
                select.empty();

                select.append('<option value="">-- Pilih Parent --</option>');

                data.forEach(parent => {
                    select.append(`<option value="${parent.id}">${parent.menuname}</option>`)
                })
                // console.log(data);
            })
            .catch((error) => {
                console.error("Error Saat Get Data Parent: ", error);
                alert("Gagal Mengambil Data Parent");
            });
    }

    const loadtable = () => {
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
                type: "GET"
            },
            columns: [
                { mData: "id" },
                { mData: "menuname" },
                { mData: "route" },
                { mData: "icon" },
                { mData: "parent_id" },
                { 
                    mData: "is_active",
                    render: function (data, type, row) {
                        return data ? '<span class="text-green-600 font-semibold">Aktif</span>' 
                                    : '<span class="text-red-600 font-semibold">Tidak Aktif</span>';
                    }
                },
                { 
                    mData: "id",
                    render: function (data, type, row) {
                        return `
                            <button 
                                class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition edit-btn" 
                                data-id="${data}">
                                Edit
                            </button>
                        `;
                    }
                }
            ],
        });

        dataTabel = $("#tabel-data").DataTable();

        $("#term").keyup(function () {
            dataTabel.search($(this).val()).draw();
            $(".table").removeAttr("style");
        });
    };

    (() => {
        loadtable();
    })();
});
