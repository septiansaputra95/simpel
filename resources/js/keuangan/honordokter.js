// const { default: axios } = require("axios");

$(function () {
    let urlGetDokter = '/Keuangan/honordokter/getDokter';
    let urlSimpan = '/Keuangan/honordokter/simpan';
    let urlLoadData = '/Keuangan/honordokter/datatables';
    let urlSend = '/Keuangan/honordokter/kirim';
    let logo = document.getElementById('loadinglogo');
    let label = document.getElementById('loadinglabel');

    let dataTabel = $("#tabel-data");

    document.getElementById("btn-tambah").onclick = () => {
        showModal();
    };

    document.getElementById("btn-simpan").onclick = () => {
        simpanData();
    };
    

    document.getElementById("btn-cari").onclick = () => {
        const tanggalawal = document.getElementById('tanggal-awal').value;
        loadtable(tanggalawal);
    };

    document.getElementById("btn-kirim").onclick = () => {
        const checkedBoxes = document.querySelectorAll('#tabel-data tbody input[type="checkbox"]:checked');
        const selectedId = Array.from(checkedBoxes).map(box => box.value);
        logo.style.visibility = 'visible';
        label.style.visibility = 'visible';
        // throw new Error("sengaja error");

        if(selectedId.length > 0)
        {
            axios
                .post(urlSend, {selectedId})
                .then(response => {
                    document.getElementById('loadinglogo').style.visibility = 'hidden';
                    document.getElementById('loadinglabel').style.visibility = 'hidden';
                    loadtable();
                    const { success, error } = response.data;
                    alert(`Pengiriman selesai! Berhasil: ${success}, Gagal: ${error}`);
                    
                })
                .catch(error => {
                    console.error('Gagal mengirim data:', error);
                    alert('Gagal mengirim data, coba lagi!');
                });
        } else {
            alert("Tolong di pilih dulu kalo mau kirim");
        }
        console.log(selectedId);
    };


    const showModal = (method = "POST") => {
        let modal = $("#modal-data");
        loadDokter();

        $("#btn-simpan").text("Simpan");
        $("#btn-simpan").show();
        $("#btn-update").hide();

        modal.modal("show");
        modal.removeAttr("style");
        return false;

    };

    const loadDokter = () => {
        axios.get(urlGetDokter)
            .then((response) => {
                let data = response.data;
                let select = $('#dokter-field');

                select.empty();

                select.append('<option value="">-- Pilih Dokter --</option>');

                data.forEach(dokter => {
                    select.append(`<option value="${dokter.kodedokter}">${dokter.namadokter}</option>`)
                })
                // console.log(data);
            })
            .catch((error) => {
                console.error("Error Saat Get Data Dokter: ", error);
                alert("Gagal Mengambil Data Dokter");
            });
    }

    const simpanData = () => {
        const tanggalAwal   = document.getElementById('form-tanggal-awal').value;
        const tanggalAkhir  = document.getElementById('form-tanggal-akhir').value;
        const dokter        = document.getElementById('dokter-field').value;
        const fileInput     = document.getElementById('file1');
        const fileInput2    = document.getElementById('file2');
        const fileInput3    = document.getElementById('file3');
        const fileInput4    = document.getElementById('file4');
        const fileInput5    = document.getElementById('file5');
        const fileInput6    = document.getElementById('file6');
        const fileInput7    = document.getElementById('file7');
        const tanggalawal2 = document.getElementById('tanggal-awal').value;
        let modal = $("#modal-data");
        // console.log(modal);
        
        // throw new Error("sengaja error");

        if(fileInput.files.length === 0)
        {
            alert("File Upload PDF Minimal 1 ya Kak");
            return;
        }

        const file = fileInput.files[0];
        const fileType = file.type;

        const file2 = fileInput2.files[0];
        const fileType2 = file2.type;

        const file3 = fileInput3.files[0];
        const fileType3 = file3.type;

        const file4 = fileInput4.files[0];
        const fileType4 = file4.type;
        
        const file5 = fileInput5.files[0];
        const fileType5 = file5.type;
        
        const file6 = fileInput6.files[0];
        const fileType6 = file6.type;
        
        const file7 = fileInput7.files[0];
        const fileType7 = file7.type;
        
        if(fileType !== "application/pdf")
        {
            alert("File 1 Upload Harus PDF Donggg");
            return;
        }

        if(fileType2 !== "application/pdf")
        {
            alert("File 2 Upload Harus PDF Donggg");
            return;
        }

        if(fileType3 !== "application/pdf")
        {
            alert("File 3 Upload Harus PDF Donggg");
            return;
        }

        if(fileType4 !== "application/pdf")
        {
            alert("File 4 Upload Harus PDF Donggg");
            return;
        }

        if(fileType5 !== "application/pdf")
        {
            alert("File 5 Upload Harus PDF Donggg");
            return;
        }

        if(fileType6 !== "application/pdf")
        {
            alert("File 6 Upload Harus PDF Donggg");
            return;
        }

        if(fileType7 !== "application/pdf")
        {
            alert("File 7 Upload Harus PDF Donggg");
            return;
        }

        const formData = new FormData();
        formData.append("tanggal_awal", tanggalAwal);
        formData.append("tanggal_akhir", tanggalAkhir);
        formData.append("dokter", dokter);
        formData.append("nama_file", file.name);
        formData.append("file", file);
        formData.append("file2", file2);
        formData.append("file3", file3);
        formData.append("file4", file4);
        formData.append("file5", file5);
        formData.append("file6", file6);
        formData.append("file7", file7);
        
        console.log("File 4: ", formData.get("file4"));
        console.log("File 5: ", formData.get("file5"));
        console.log("File 6: ", formData.get("file6"));
        
        // throw new Error("sengaja error");

        modal.modal("hide");
        axios
            // .post(urlSimpan, formData, {
            //     headers: {
            //         'Content-Type': 'application/json'
            //     }
            // })
            // .post(urlSimpan, formData)
            .post(urlSimpan, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
        .then(response => {
            // console.log("Simpan Data berhasil", response.data)
            alert(response.data.message);
            resetModal();
            loadtable(tanggalawal2);
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
        document.getElementById('form-tanggal-awal').value = '';
        document.getElementById('form-tanggal-akhir').value = '';
        document.getElementById('dokter-field').value = '';
        document.getElementById('file1').value = '';
        document.getElementById('file2').value = '';
        document.getElementById('file3').value = '';
        document.getElementById('file4').value = '';
        document.getElementById('file5').value = '';
        document.getElementById('file6').value = '';
        document.getElementById('file7').value = '';


        // document.getElementById('modal-data').reset();
    };

    const loadtable = (tanggal) => {
        $("#tabel-data").dataTable({
            processing: true,
            serverSide: true,
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
                { mData: "kodedokter" },
                { mData: "namadokter" },
                { mData: "tanggalawal" },
                { mData: "tanggalakhir" },
                { mData: "flagkirim" },
                { 
                    mData: "flagkirim_checkbox",
                    mRender: function (data, type, row) {
                        return data; // Render langsung dari server
                    },
                }
            ],
            drawCallback: function (settings) {
                const dataCount = this.api().data().count(); // Hitung jumlah data
                if (dataCount > 0) {
                    $("#btn-kirim").text("Kirim");
                    $("#btn-kirim").show();
                } else {
                    $("#btn-kirim").hide(); // Sembunyikan tombol jika tidak ada data
                }
            },
        });

        dataTabel = $("#tabel-data").DataTable();

        $("#term").keyup(function () {
            dataTabel.search($(this).val()).draw();
            $(".table").removeAttr("style");
        });
    };

    (() => {
        const tanggal = document.getElementById("tanggal-awal").value;
        document.getElementById('loadinglogo').style.visibility = 'hidden';
        document.getElementById('loadinglabel').style.visibility = 'hidden';
        loadtable(tanggal);
    })();
});
