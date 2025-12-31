
$(function () {
    let urlLoadData = '/masterdokter/datatables';
    // let urlSimpan = "{{ route('masterdokter.store') }}";
    let urlSimpan = '/masterdokter/simpan';
    let urlUpdate = '/masterdokter/update';

    let dataTabel = $("#tabel-data");

    document.getElementById("btn-tambah").onclick = () => {
        showModal();
    };

    document.getElementById("btn-simpan").onclick = () => {
        simpanData();
    };

    document.getElementById("btn-update").onclick = () => {
        updateData();
    };

    // document.getElementById("btn-edit").onclick = () => {
    //     editDokter();
    // };

    function editDokter(id) {
        let button = $("button[onclick='editDokter(" + id + ")']");
        let inputKodeDokter = $("#kode-dokter");

        inputKodeDokter.prop('readonly', true);

        let kodedokter = button.data("kodedokter");
        let namadokter = button.data("namadokter");
        let emaildokter = button.data("emaildokter");

        // console.log(kodedokter, namadokter, emaildokter);
        
        let modal = $("#modal-data");
        document.getElementById('kode-dokter').value = kodedokter;
        document.getElementById('nama-dokter').value = namadokter;
        document.getElementById('email-dokter').value = emaildokter;

        $("#btn-update").text("Update");
        $("#btn-update").show();
        $("#btn-simpan").hide()

        modal.modal("show");
    }

    const showModal = (method = "POST") => {
        let modal = $("#modal-data");
        let inputKodeDokter = $("#kode-dokter");

        inputKodeDokter.prop('readonly', false);
        resetModal();

        $("#btn-simpan").text("Simpan");
        $("#btn-simpan").show();
        $("#btn-update").hide();

        modal.modal("show");
        modal.removeAttr("style");
        return false;

    };

    const simpanData = () => {
        const kodedokter    = document.getElementById('kode-dokter').value;
        const namadokter    = document.getElementById('nama-dokter').value;
        const emaildokter   = document.getElementById('email-dokter').value;
        let modal = $("#modal-data");
        // console.log(modal);
        
        if (!kodedokter) {
            alert("Di Isi Dulu Kode Dokter nya, sesuai di HINAI");
            return; // Menghentikan eksekusi jika input kosong
        }
    
        if (!namadokter) {
            alert("Di Isi Dulu Nama Dokter nya");
            return;
        }
    
        if (!emaildokter) {
            alert("Di Isi Dulu Email Dokter nya");
            return;
        }
        

        const formData = new FormData();
        formData.append("kodedokter", kodedokter);
        formData.append("namadokter", namadokter);
        formData.append("emaildokter", emaildokter);
        // console.log("kodedokter:", formData.get("kodedokter"));
        // console.log("namadokter:", formData.get("namadokter"));
        // console.log("emaildokter:", formData.get("emaildokter"));
        // throw new Error("sengaja error");
        // console.log("Mengirim data ke:", urlSimpan);
        // modal.modal("hide");
        axios
            .post(urlSimpan, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
        .then(response => {
            // console.log("Simpan Data berhasil", response.data)
            // console.log('Response dari server:', response.data);
            resetModal();
            modal.modal("hide");
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

    const updateData = () => {
        const kodedokter    = document.getElementById('kode-dokter').value;
        const namadokter    = document.getElementById('nama-dokter').value;
        const emaildokter   = document.getElementById('email-dokter').value;
        let modal = $("#modal-data");
        // console.log(modal);
        
        if (!kodedokter) {
            alert("Di Isi Dulu Kode Dokter nya, sesuai di HINAI");
            return; // Menghentikan eksekusi jika input kosong
        }
    
        if (!namadokter) {
            alert("Di Isi Dulu Nama Dokter nya");
            return;
        }
    
        if (!emaildokter) {
            alert("Di Isi Dulu Email Dokter nya");
            return;
        }
        

        const formData = new FormData();
        formData.append("kodedokter", kodedokter);
        formData.append("namadokter", namadokter);
        formData.append("emaildokter", emaildokter);
        // console.log("kodedokter:", formData.get("kodedokter"));
        // console.log("namadokter:", formData.get("namadokter"));
        // console.log("emaildokter:", formData.get("emaildokter"));
        // throw new Error("sengaja error");
        // console.log("Mengirim data ke:", urlUpdate);
        // modal.modal("hide");
        axios
            .post(urlUpdate, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
        .then(response => {
            // console.log("Simpan Data berhasil", response.data)
            // console.log('Response dari server:', response.data);
            resetModal();
            modal.modal("hide");
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
        document.getElementById('kode-dokter').value = '';
        document.getElementById('nama-dokter').value = '';
        document.getElementById('email-dokter').value = '';
    };
    window.editDokter = editDokter;
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
                { mData: "no" },
                { mData: "kodedokter" },
                { mData: "namadokter" },
                { mData: "emaildokter" },
                { mData: "action" }
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
