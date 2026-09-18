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

    const menuColorPalette = [
    {
        bg: "bg-accent-bg",
        text: "text-accent"
    },
    {
        bg: "bg-blue-bg",
        text: "text-blue"
    },
    {
        bg: "bg-teal-bg",
        text: "text-teal"
    },
    {
        bg: "bg-amber-bg",
        text: "text-amber"
    },
    {
        bg: "bg-rose-bg",
        text: "text-rose"
    },
    {
        bg: "bg-violet-100",
        text: "text-violet-600"
    },
    {
        bg: "bg-indigo-100",
        text: "text-indigo-600"
    },
    {
        bg: "bg-cyan-100",
        text: "text-cyan-600"
    },
    {
        bg: "bg-orange-100",
        text: "text-orange-600"
    },
    {
        bg: "bg-pink-100",
        text: "text-pink-600"
    }
];

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

    const getMenuColor = (id) => {
        return menuColorPalette[
            Number(id) % menuColorPalette.length
        ];
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
                // { mData: "id" },
                {
                    mData: "id",
                    
                    createdCell: function (td) {
                        $(td).addClass("px-5 py-3.5 text-center");
                    },

                    render: function (data, type, row) {
                        return `
                            <span class="text-slate-400 font-mono text-xs">
                                ${data ?? '-'}
                            </span>
                        `;
                    }
                },
                // { mData: "menuname" },
                {
                    mData: "menuname",
                    render: function (data, type, row) {

                        const color = getMenuColor(row.id);

                        return `
                            <div class="flex items-center gap-3 font-semibold text-ink">
                                <span class="w-8 h-8 rounded-lg flex items-center justify-center ${color.bg} ${color.text}">
                                    <i class="bi ${row.icon ?? 'bi-list'}"></i>
                                </span>
                                ${data}
                            </div>
                        `;
                    }
                },
                {
                    mData: "route",
                    render: function (data, type, row) {
                        return data
                            ? `<span class="bg-slate-100 text-slate-500 font-mono text-xs px-2 py-1 rounded">${data}</span>`
                            : `<span class="text-slate-300">—</span>`;
                    }
                },
                // { mData: "icon" },
                {
                    mData: "icon",
                    render: function (data, type, row) {
                        return `
                            <span class="text-slate-400 font-mono text-xs">
                                ${data ?? '-'}
                            </span>
                        `;
                    }
                },
                {
                    mData: "parent_id",
                    render: function (data, type, row) {
                        return data
                            ? `<span class="text-slate-400 font-semibold text-xs">#${data}</span>`
                            : `<span class="text-slate-300">—</span>`;
                    }
                },
                {
                    mData: "is_active",
                    render: function (data, type, row) {
                        return data
                            ? `
                                <span class="inline-flex items-center gap-1.5 bg-green-bg text-green font-semibold text-xs px-2.5 py-1 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green"></span>
                                    Aktif
                                </span>
                            `
                            : `
                                <span class="inline-flex items-center gap-1.5 bg-red-bg text-red font-semibold text-xs px-2.5 py-1 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red"></span>
                                    Tidak Aktif
                                </span>
                            `;
                    }
                },
                {
                    mData: "id",
                    render: function (data, type, row) {
                        return `
                            <button
                                class="border border-bd text-blue font-semibold text-xs rounded-md px-3 py-1.5 hover:bg-blue-bg"
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
