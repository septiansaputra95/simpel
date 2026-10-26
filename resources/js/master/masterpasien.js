$(function () {

    let urlLoadData = "/masterpasien/datatables";
    let dataTabel = $("#tabel-data").DataTable();

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

    const getMenuColor = (id) => {

        const index = Number(id);

        if (Number.isNaN(index)) {
            return menuColorPalette[0];
        }

        return menuColorPalette[
            Math.abs(index) % menuColorPalette.length
        ];
    };
    $("#searchInput").on("keyup", function () {
        dataTabel.search(this.value).draw();
    });

    $("#formMasterPasien").on("submit", function (e) {

        e.preventDefault();

        const requiredFields = [
            {
                name: "registration_date",
                label: "Registration Date"
            },
            {
                name: "patientname",
                label: "Patient Name"
            },
            {
                name: "gender",
                label: "Gender"
            },
            {
                name: "dateofbirth",
                label: "Date of Birth"
            },
            {
                name: "address",
                label: "Address"
            },
            {
                name: "idbpjs",
                label: "BPJS ID"
            }
        ];

        $("[name]").removeClass("border-red-500");

        for (const field of requiredFields) {

            const input = $(`[name="${field.name}"]`);

            if (!input.val() || input.val().trim() === "") {

                input.addClass("border-red-500");

                alert(`${field.label} wajib diisi.`);

                input.focus();

                return;
            } else {
                const arrayInput [] = input.val().trim();
            }

        }

        const idbpjsInput =  $('[name="idbpjs"]');
        const idbpjs = idbpjsInput.val().trim();

        if (idbpjs.length !== 13) {
            idbpjsInput.addClass("border-red-500");
            alert("ID BPJS harus terdiri dari tepat 13 karakter.");
            idbpjsInput.focus();
            return;
        }
        console.log("Form valid");
        simpanData()
    });
    const simpanData = () => {

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

            ajax: {
                url: urlLoadData,
                type: "GET"
            },

            columns: [

            // MRN
            {
                mData: "mrn",

                createdCell: function (td) {
                    $(td).addClass("px-5 py-3.5 text-center");
                },

                render: function (data) {
                    return `
                        <span class="font-mono text-xs text-slate-500">
                            ${data ?? '-'}
                        </span>
                    `;
                }
            },

            // NAMA PASIEN
            {
                mData: "patientname",

                render: function (data, type, row) {

                    const color = getMenuColor(row.id);

                    return `
                        <div class="flex items-center gap-3 font-semibold text-ink">
                            <span class="w-8 h-8 rounded-lg flex items-center justify-center ${color.bg} ${color.text}">
                                <i class="bi bi-person-fill"></i>
                            </span>

                            <span>
                                ${data ?? '-'}
                            </span>
                        </div>
                    `;
                }
            },

            // GENDER
            {
                mData: "gender",

                createdCell: function (td) {
                    $(td).addClass("px-5 py-3.5 text-center");
                },

                render: function (data) {

                    let gender = '-';

                    if (data === 'L') {
                        gender = 'Laki-laki';
                    } else if (data === 'P') {
                        gender = 'Perempuan';
                    }

                    return `
                        <span class="text-sm text-slate-600">
                            ${gender}
                        </span>
                    `;
                }
            },

            // TANGGAL LAHIR
            {
                mData: "dateofbirth",
                
                createdCell: function (td) {
                    $(td).addClass("px-5 py-3.5 text-center");
                },
                

                render: function (data) {
                    if (!data) {
                        return `
                            <span class="text-sm text-slate-300">-</span>
                        `;
                    }
                    const [tahun, bulan, hari] = data.split("-");
                    const tanggal = `${hari}-${bulan}-${tahun}`;

                    return `
                        <span class="text-sm text-slate-600">
                            ${tanggal ?? '-'}
                        </span>
                    `;
                }
            },

            // ALAMAT
            {
                mData: "address",

                render: function (data) {
                    return `
                        <span class="text-sm text-slate-600">
                            ${data ?? '-'}
                        </span>
                    `;
                }
            },

            // ID BPJS
            {
                mData: "idbpjs",

                createdCell: function (td) {
                    $(td).addClass("px-5 py-3.5 text-center");
                },

                render: function (data) {
                    return `
                        <span class="font-mono text-xs text-slate-500">
                            ${data ?? '-'}
                        </span>
                    `;
                }
            },

            // AKSI
            {
                mData: "id",

                createdCell: function (td) {
                    $(td).addClass("px-5 py-3.5 text-center");
                },

                render: function (data) {
                    return `
                        <button
                            class="border border-bd text-blue font-semibold text-xs rounded-md px-3 py-1.5 hover:bg-blue-bg"
                            data-id="${data}">
                            Edit
                        </button>
                    `;
                }
            }

        ]
        });

        // const dataTabel = $("#tabel-data").DataTable();
        // Ambil instance DataTables
        dataTabel = $("#tabel-data").DataTable();

        $("#searchInput").on("keyup", function () {
            dataTabel.search(this.value).draw();
        });

    };

    loadtable();

});