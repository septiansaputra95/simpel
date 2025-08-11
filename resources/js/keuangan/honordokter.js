// const { default: axios } = require("axios");

$(function () {
    let urlGetDokter = '/Keuangan/honordokter/getDokter';
    let urlSimpan = '/Keuangan/honordokter/simpan';
    let urlLoadData = '/Keuangan/honordokter/datatables';
    let urlSend = '/Keuangan/honordokter/kirim';
    let logo = document.getElementById('loadinglogo');
    let label = document.getElementById('loadinglabel');

    let hasilUpload = []; // untuk menampung status setiap dokter
    let totalDokter = 0;
    let selesaiUpload = 0;

    let dataTabel = $("#tabel-data");
    let fileCounter = 1;
    let modal = $("#modal-data");
    let sudahAlert = false;

    document.getElementById("btn-tambah").onclick = () => {
        showModal();
    };

    document.getElementById("btn-simpan").onclick = () => {
        // simpanData();
        simpanDataFilePond();
    };
    

    document.getElementById("btn-cari").onclick = () => {
        const tanggalawal = document.getElementById('tanggal-awal').value;
        loadtable(tanggalawal);
    };

    // document.getElementById('add-file-button').addEventListener('click', addFileInput);
    // document.getElementById('remove-file-button').addEventListener('click', removeFileInput);

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
        // console.log(selectedId);
    };

    // function addFileInput() {
    //     fileCounter++; // Increment counter

    //     // Buat elemen input file baru
    //     const newFileInput = document.createElement('input');
    //     newFileInput.type = 'file';
    //     newFileInput.className = 'form-control';
    //     newFileInput.id = 'file_' + fileCounter; // Set ID sesuai dengan counter

    //     // Buat elemen div untuk mengelompokkan input file
    //     const inputGroup = document.createElement('div');
    //     inputGroup.className = 'input-group mb-3';
    //     inputGroup.appendChild(newFileInput);

    //     // Tambahkan input file baru ke dalam wadah
    //     const container = document.getElementById('file-inputs-container');
    //     container.appendChild(inputGroup);
    // }

    // function removeFileInput() {
    //     if (fileCounter > 1) { // Pastikan ada lebih dari satu input file
    //         const container = document.getElementById('file-inputs-container');
    //         // Hapus elemen terakhir yang ditambahkan
    //         container.removeChild(container.lastChild);
    //         fileCounter--; // Decrement counter
    //     }
    // }

    const showModal = (method = "POST") => {
        
        loadDokter();

        $("#btn-simpan").text("Simpan");
        $("#btn-simpan").show();
        $("#btn-update").hide();

        modal.modal("show");
        // modal.removeAttr("style");
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
        const fileInput = document.getElementById('file_1');
        const tanggalawal2 = document.getElementById('tanggal-awal').value;
        // const fileInputs = [fileInput, fileInput2, fileInput3, fileInput4, fileInput5, fileInput6, fileInput7];
        // const fileInputs = [];
        const fileInputs = document.querySelectorAll('#file-inputs-container input[type="file"]');
        const files = [];
        let fileType, fileType2, fileType3, fileType4, fileType5, fileType6, fileType7;
        let allFilesArePDF = true; 
        let hasFile = false;
        
        let modal = $("#modal-data");

        const formData = new FormData();
        formData.append("tanggal_awal", tanggalAwal);
        formData.append("tanggal_akhir", tanggalAkhir);
        formData.append("dokter", dokter);

        // console.log('di luar IF'); //  fileInputs.forEach(input => { tidak ter-eksekusi sehingga semua logika salah
        // console.log(fileInputs); // fileInputs file input isinya kosong harus cari tahu gimana kok bisa kosong
        // fileInputs.forEach(input => {
        //     if (input.files.length > 0) {
        //         hasFile = true; // Set hasFile menjadi true jika ada f
        //         console.log('Masuk ke ke IF');
        //         // ile
        //         // Periksa setiap file
        //         for (let i = 0; i < input.files.length; i++) {
        //             const file = input.files[i];
        //             console.log('Masuk ke perulangan');
        //             console.log(`File Name: ${file.name}, File Type: ${file.type}`);
        //             // Periksa ekstensi file
        //             if (file.type !== 'application/pdf') {
        //                 allFilesArePDF = false;
        //             }
        //         }
        //     }
        // });

        fileInputs.forEach((input, index) => {
            if (input.files.length > 0) {
                hasFile = true;
                // console.log('Masuk ke IF');
        
                for (let i = 0; i < input.files.length; i++) {
                    const file = input.files[i];
                    const key = `file${index + 1}`;
                    formData.append(key, file);
                    // console.log(`File Name: ${file.name}, File Type: ${file.type}`);
        
                    // Cek apakah file adalah PDF
                    if (file.type !== 'application/pdf') {
                        allFilesArePDF = false;
                    }
        
                    // files.push(file);
                }
            }
        });


        if(fileInput.files.length === 0)
        {
            alert("File Upload PDF Minimal 1 ya Kak");
            return;
        }

        // console.log('allfilesArePDF : ' + allFilesArePDF);
        if (!allFilesArePDF) {
            alert("Semua file yang diunggah harus berformat PDF.");
            return;
        }
        const tanggalAwalValue = formData.get("tanggal_awal");
        const tanggalAkhirValue = formData.get("tanggal_akhir");
        const dokterValue = formData.get("dokter");

        // console.log("Cek Data Form:");
        // console.log("Tanggal Awal:", tanggalAwalValue);
        // console.log("Tanggal Akhir:", tanggalAkhirValue);
        // console.log("Dokter:", dokterValue);

        // **Cek apakah file berhasil ditambahkan**
        // console.log("Cek file yang ada di FormData:");
        for (let pair of formData.entries()) {
            if (pair[0].startsWith("file")) {
                // console.log(`File key: ${pair[0]}, File name: ${pair[1].name}, File type: ${pair[1].type}`);
            }
        }
        // throw new Error("sengaja error");

        axios
            .post(urlSimpan, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
        .then(response => {
            // console.log("Simpan Data berhasil", response.data)
            alert(response.data.message);
            // resetModal();
            loadtable(tanggalawal2);
            modal.modal("hide");
            document.getElementById("form-hd").reset();
        })
        // .catch(error => {
        //     console.error("Error saat menyimpan data ", error)
        //     // alert("Gagal Saat Simpan Data");

        //     if (error.response) {
        //         alert(error.response.data.message || "Gagal Saat Simpan Dataaa");
        //     } else {
        //         alert("Terjadi kesalahan jaringan");
        //     }
        // })
    }

    const simpanDataFilePond = () => {
        const tanggalAwal   = document.getElementById('form-tanggal-awal').value;
        const tanggalAkhir  = document.getElementById('form-tanggal-akhir').value;

        const pond = FilePond.find(document.getElementById('filepond-input'));

        if (pond) {
            const files = pond.getFiles(); // array of file objects

            const fileNames = files.map(file => file.filename);

            const shortNames = fileNames.map(name => {
                const index = name.indexOf('_');
                return index !== -1 ? name.substring(0, index) : name;
            });

            console.log("Tanggal Awal:", tanggalAwal);
            console.log("Tanggal Akhir:", tanggalAkhir);
            console.log("File yang diupload (asli):");
            // fileNames.forEach(name => console.log(name));

            console.log("Nama pendek (sebelum '_'):");
            // shortNames.forEach(name => console.log(name));

            const uniqueShortNames = [...new Set(shortNames)];
            console.log("Short names:", shortNames);
            console.log("Short names (UNIQUE):", uniqueShortNames);

            for (let i = 0; i < uniqueShortNames.length; i++) {
                const dokter = uniqueShortNames[i];
                const filesDokter = files.filter(file => file.filename.startsWith(dokter + '_'));
                prosesSimpan(tanggalAwal, tanggalAkhir, dokter, filesDokter);
            }
            
            // Sekarang kamu punya:/
            // fileNames → nama lengkap
            // shortNames → versi nama singkat/
        } else {
            console.warn("FilePond belum ter-inisialisasi");
        }
    }

    const prosesSimpan = (tanggalAwal, tanggalAkhir, dokter, filesDokter) => {
        totalDokter++;

        // const fileDokter = files.find(file => file.filename.startsWith(dokter + '_'));
        const semuaPDF = filesDokter.every(file => file.fileType === 'application/pdf');
        if(!semuaPDF){
            alert("Semua file yang diunggah harus berformat PDF.");
            return;
        }

        console.log("dokter: ", dokter);
        console.log(`Jumlah file untuk dokter ${dokter}:`, filesDokter.length);

        filesDokter.forEach(file => {
            console.log(`Nama file: ${file.filename}`);
        });

        const formData = new FormData();

        formData.append('tanggalAwal', tanggalAwal);
        formData.append('tanggalAkhir', tanggalAkhir);
        formData.append('dokter', dokter);

        filesDokter.forEach((fileObj, index) => {
            formData.append(`file_${index}`, fileObj.file); // fileObj.file adalah file asli
        });
        
        axios
            .post(urlSimpan, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(function (res) {
            if (res.data.code == 200) {
                hasilUpload.push({ dokter, status: 'sukses', pesan: res.data.message });

                // alert(res.data.message);
                // location.reload();
            } else {
                hasilUpload.push({ dokter, status: 'gagal', pesan: 'Penyimpanan gagal' });
                // alert("Penyimpanan data gagal untuk dokter: " + dokter);
            }
        })
        .catch(function (err) {
            hasilUpload.push({ dokter, status: 'gagal', pesan: 'Error koneksi' });
            // alert("Gagal menyimpan data dokter " + dokter);
            console.error("Error:", err);
        })
        .finally(() => {
            selesaiUpload++;
            cekSelesai();
        });
    }

    const cekSelesai = () => {
        if (selesaiUpload === totalDokter) {
            const gagal = hasilUpload.filter(item => item.status === 'gagal');
            if (gagal.length > 0) {
                alert("Upload selesai, tapi ada yang gagal:\n" +
                    gagal.map(g => `${g.dokter}: ${g.pesan}`).join("\n"));
            } else {
                alert("Semua file berhasil diupload!");
            }
            location.reload();
        }
    };

    const uploadFiles = () => {

    }

    const loadtable = (tanggal) => {
        const table = $("#tabel-data").dataTable({
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

        table.one('xhr.dt', function (e, settings, json, xhr) {
            if (json && json.error_message) {
                alert(json.error_message);
            }
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
