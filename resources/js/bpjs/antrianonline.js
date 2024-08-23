$(function () {
    let urlLoadData = "/BPJS/antrianonline/datatables";
    let urlSimpan = "/BPJS/antrianonline/simpan";

    // Initisalisasi
    let dataTabel = $("#tabel-data");

    let formModal = $("#form-data");

    document.getElementById("btn-cari").onclick = () => {
        let tanggal = document.getElementById('tanggal-antrian').value;
        console.log(tanggal);
        data(tanggal);
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
    
    const data = (tanggal) => {
        $("#tabel-data").dataTable({
            Processing: true,
            ServerSide: true,
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
                url: urlLoadData,
                type: "GET",
                data: {
                    tanggal: tanggal
                },
            },
            columns: [
                { mData: "no" },
                { mData: "kodebooking" },
                { mData: "tanggal" },
                { mData: "kodepoli" },
                { mData: "kodedokter" },
                { mData: "nokapst" },
                { mData: "nohp" },
                { mData: "norekammedis" },
                { mData: "jeniskunjungan" },
                { mData: "nomorreferensi" },
                { mData: "sumberdata" },
                { mData: "noantrean" },
                { mData: "estimasidilayani" },
                { mData: "createdtime" },
                { mData: "status" },
            ],
        });

        dataTabel = $("#tabel-data").DataTable();

        $("#term").keyup(function () {
            dataTabel.search($(this).val()).draw();
            $(".table").removeAttr("style");
        });
    };

    (() => {
        const tanggal = document.getElementById("tanggal-antrian").value; 
        data(tanggal);
    })();
});
