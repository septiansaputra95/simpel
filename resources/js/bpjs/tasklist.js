$(function () {
    let urlLoadData = "/BPJS/tasklist/datatables";
    let urlSimpan = "/BPJS/tasklist/simpan";
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
       // Mengirim data sebagai object dalam POST request
        // axios
        //     .post(urlTask, { kodebooking: kodebooking })
        //     .then(function (res) {
        //         console.log(res);  // Mencetak seluruh response object dari server
        //         if (res.data.code == 200) {
        //             let message = res.data.message;

        //             alert(message);
        //         } else {
        //             // Jika response code tidak 200
        //             console.error("Error: ", res.data.message);
        //         }
        // })
        // .catch(function (err) {
        //     console.log(err);  // Mencetak error object
        //     if (err.response && err.response.code != 200) {
        //         swalWithBootstrapButtons.fire(
        //             "Gagal Menambah data!",
        //             err.response.data.message,
        //             "error"
        //         );
        //         alert(err.response.data.message);
        //     } else {
        //         console.error("Request failed: ", err.message);
        //     }
        // });
    };

    document.getElementById("btn-simpan").onclick = () => {
        let tanggal = document.getElementById('tanggal-antrian').value;
        console.log(tanggal);
        simpanData(tanggal);
    };

    const simpanData = (tanggal) => {
        const tanggalData = tanggal;
        console.log(tanggalData);
        axios
            .get(urlSimpan, {
                params: {
                    tanggal:tanggal
                }
            })
            .then(function (res) {
                // console.log(res);
                if (res.data.code == 200) {
                    alert(res.data.message  );
                    dataTabel.ajax.reload();
                }
            })
            .catch(function (err) {
                if (err.response.code != 200) {
                    alert("Gagal Menyimpan Antrian Tanggal");
                }
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
