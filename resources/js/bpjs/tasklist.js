$(function () {
    let urlLoadData = "/BPJS/tasklist/datatables";
    let urlSimpan = "/BPJS/tasklist/simpan";
    let urlCariData = "/BPJS/tasklist/getKodeBooking"
    let urlTask = "/BPJS/tasklist/getTask";

    // Initisalisasi
    let dataTabel = $("#tabel-data");
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    let formModal = $("#form-data");

    document.getElementById("btn-cari").onclick = () => {
        let kodebooking = document.getElementById('kodebooking').value;
        console.log(kodebooking);
        console.log("getKodebooking");
        data(kodebooking);
    };

    document.getElementById("btn-mining").onclick = () => {
        console.log("Add Data");
        // console.log($); // Should print the jQuery object/function
        // console.log($.fn.modal); // Should print the Bootstrap modal functio
        showModal();
    };


    const showModal = (method = "POST") => {
        let modal = $("#modal-data");

        $("#btn-simpan").text("Simpan");
        $("#btn-simpan").show();
        $("#btn-update").hide();

        modal.modal("show");
        modal.removeAttr("style");
        return false;
    };

    const simpanData = (kodebooking, tanggal) => {
        axios
            .get(urlSimpan, {
                params: {
                    kodebooking:kodebooking,
                    tanggal:tanggal
                }
            })
            .then(function (res) {
                // console.log(res);
                //console.log("simpanData");
                if (res.data.code == 200) {
                    console.log("Data Berhasil Disimpan");

                } else {
                    alert("Penyimpanan Data Gagal");
                }
            })
            .catch(function (err) {
                if (err.response && err.response.status !== 200) {
                    alert("Gagal Menyimpan KodeBooking");
                } else {
                    console.error("Terjadi kesalahan Pada SimpanData:", err.message);
                }
            });
    };

    //window.simpanData = simpanData;

    document.getElementById("btn-simpan").onclick = () => {
        const tanggal = document.getElementById("tanggal-task").value;
        cariData(tanggal);
    };

    document.getElementById("btn-caridb").onclick = () => {
        const tanggal = document.getElementById("tanggal-task").value;
        console.log(tanggal);
    };
    const cariData = (tanggal) => {
        const tanggalData = tanggal;
        console.log(tanggalData);
        axios
            .get(urlCariData, {
                params: {
                    tanggal:tanggal
                }
            })
            .then(function (res) {
                console.log(res.data);
                if (res.data.length > 0) {
                    res.data.forEach(item => {
                        console.log(item.kodebooking); // Menampilkan setiap kodebooking
                        simpanData(item.kodebooking, tanggal);
                        //throw new Error("Menghentikan eksekusi skrip");
                    });
                    alert("Semua Data Kode Booking Berhasil Disimpan");
                    //dataModal(tanggalData);
                } else {
                    alert("Gagal Pencarian Kode Booking");
                }
            })
            .catch(function (err) {
                if (err.response && err.response.status !== 200) {
                    alert("Gagal Pencarian Kode Booking Dengan Tanggal Dari Database");
                } else {
                    console.error("Terjadi kesalahan CariData:", err.message);
                }
            });
    }

    const data_modal = (tanggal) => {
        $("#tabel-modal").dataTable({
            processing: true,  // "Processing" should be lowercase.
            serverSide: true,  // "ServerSide" should be lowercase.
            paging: true,
            sDom: "<t <'float-end' i><p >>",
            iDisplayLength: 25,
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
                url: urlTask,  // Add a comma here
                type: "GET",
                data: {
                    tanggal: tanggal
                },
            },
            columns: [
                { mData: "no" },
                { mData: "wakturs" },
                { mData: "waktu" },
                { mData: "taskname" },
                { mData: "taskid" },
                { mData: "kodebooking" },
            ],
        });
    
            dataTabel = $("#tabel-modal").DataTable();
    
            $("#term").keyup(function () {
                dataTabel.search($(this).val()).draw();
                $(".table").removeAttr("style");
            });
    };
    
    const data = (kodebooking) => {
    $("#tabel-data").dataTable({
        processing: true,  // "Processing" should be lowercase.
        serverSide: true,  // "ServerSide" should be lowercase.
        paging: true,
        sDom: "<t <'float-end' i><p >>",
        iDisplayLength: 25,
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
            url: urlLoadData,  // Add a comma here
            type: "POST",
            data: {
                kodebooking: kodebooking
            },
        },
        columns: [
            { mData: "no" },
            { mData: "wakturs" },
            { mData: "waktu" },
            { mData: "taskname" },
            { mData: "taskid" },
            { mData: "kodebooking" },
        ],
    });

        dataTabel = $("#tabel-data").DataTable();

        $("#term").keyup(function () {
            dataTabel.search($(this).val()).draw();
            $(".table").removeAttr("style");
        });
    };

    (() => {
        // const tanggal = document.getElementById("tanggal-antrian").value; 
        // data(tanggal);
    })();
});
