
$(function () {
    let urlLoadData = '/permintaan/datatables';
    // let urlSimpan = "{{ route('masterdokter.store') }}";
    let urlSimpan = '/stokgudang/simpan';
    let urlUpdate = '/stokgudang/update';
    let urlGudang = '/stokgudang/getGudang';
    let urlBarang = '/stokgudang/getBarang';
    let urlSatuan = '/stokgudang/getSatuan';
    
    const urlEdit = (id) => `/stokgudang/${id}/getEdit`;
    // const urlUpdate = (id) => `/stokgudang/${id}/update`;

    let dataTabel = $("#tabel-data");
    let modal = $("#modal-data");

    const inputHarga = document.getElementById('harga');

    let no = 1 ;

    document.getElementById("btn-tambah").onclick = () => {
        tambahModal();
        resetModal();
        showModal();
    };

    document.getElementById("btn-simpan").onclick = () => {
        // console.log("masuk ke button simpan");
        const gudang   = document.getElementById('gudang').value;
        const barang   = document.getElementById('barang').value;
        const satuan   = document.getElementById('satuan').value;
        const hargaRaw = document.getElementById('harga').value;
        const stok     = document.getElementById('stok').value;
        const isActive = document.getElementById('is_active').value;

        if (!gudang) {
            alert('Gudang wajib dipilih');
            return;
        }

        if (!barang) {
            alert('Barang wajib dipilih');
            return;
        }

        if (!satuan) {
            alert('Satuan wajib dipilih');
            return;
        }

        if (!hargaRaw) {
            alert('Harga wajib diisi');
            return;
        }

        if (!stok) {
            alert('Stok wajib diisi');
            return;
        }
        const harga = parseInt(
            hargaRaw.replace(/[^0-9]/g, ''),
            10
        ) || 0;
        simpanData(gudang, barang, satuan, harga, stok, isActive);
        resetModal();
        TutupModal();
        
    };

    document.getElementById("btn-update").onclick = () => {
        const data = checkdata();

        if (!data || data.length === 0) {
            alert("Data gagal tervalidasi checkdata");
            return;
        }
        updateData(data);
        resetModal();
        TutupModal();
    };

    // UNTUK MENGEDIT STOK
    $(document).on('click', '.btn-edit', function () {
        const button = $(this);

        const gudangstokid = button.data('gudangstokid');
        const kode_gudang  = button.data('kode_gudang');

        // console.log('sudah sampai editStok', button, gudangstokid, kode_gudang);

        getEdit(gudangstokid)
        editModal();
        readOnly();

    });
    const showModal = (method = "POST") => {
        getGudang();
        getBarang();
        getSatuan();

        modal.removeClass("hidden"); // Buka Modal
        return false;

    };

    const TutupModal = () => {
    
        modal.addClass("hidden"); // Buka Modal
        return false;

    };

    const tambahModal =() => {
        $("#btn-simpan").text("Simpan"); // Mengubah text button 
        $("#btn-simpan").show();
        $("#btn-update").hide();
    }

    const editModal =() => {
        $("#btn-update").text("Update"); // Mengubah text button 
        $("#btn-update").show();
        $("#btn-simpan").hide();

    }

   

    const simpanData = (gudang, barang, satuan, harga, stok, isActive) => {
             
        const formData = new FormData();
        formData.append("gudang", gudang);
        formData.append("barang", barang);
        formData.append("satuan", satuan);
        formData.append("harga", harga);
        formData.append("stok", stok);
        formData.append("isActive", isActive)

        axios
            .post(urlSimpan, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
        .then(response => {
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

    const updateData = (data) => {
       
        const formData = new FormData();
        formData.append("id", data.id);
        formData.append("gudang", data.gudang);
        formData.append("barang", data.barang);
        formData.append("satuan", data.satuan);
        formData.append("harga", data.harga);
        formData.append("stok", data.stok);
        formData.append("isActive", data.isActive)

        // console.log('updateData', formData);
        // throw new Error("Error message");
        axios
            .post(urlUpdate, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
        .then(response => {
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
        document.getElementById('gudang').disabled  = false;
        document.getElementById('barang').disabled  = false;
        document.getElementById('satuan').disabled  = false;

        document.getElementById('gudang').value = '';
        document.getElementById('barang').value = '';
        document.getElementById('satuan').value = '';
        document.getElementById('harga').value = '';
        document.getElementById('stok').value = '';
        document.getElementById('is_active').value = '1';
    };

    const readOnly = () => 
    {
        document.getElementById('gudang').disabled  = true;
        document.getElementById('barang').disabled  = true;
        document.getElementById('satuan').disabled  = true;
    }

    const checkdata = () => {
        const id   = document.getElementById('id').value;
        const gudang   = document.getElementById('gudang').value;
        const barang   = document.getElementById('barang').value;
        const satuan   = document.getElementById('satuan').value;
        const hargaRaw = document.getElementById('harga').value;
        const stok     = document.getElementById('stok').value;
        const isActive = document.getElementById('is_active').value;

        if (!gudang) {
            alert('Gudang wajib dipilih');
            return;
        }

        if (!barang) {
            alert('Barang wajib dipilih');
            return;
        }

        if (!satuan) {
            alert('Satuan wajib dipilih');
            return;
        }

        if (!hargaRaw) {
            alert('Harga wajib diisi');
            return;
        }

        if (!stok) {
            alert('Stok wajib diisi');
            return;
        }
        const harga = parseInt(
            hargaRaw.replace(/[^0-9]/g, ''),
            10
        ) || 0;

        return {
            id,
            gudang,
            barang,
            satuan,
            harga,
            stok,
            isActive
        };

    }

     // RUPIAH
    inputHarga.addEventListener('input', function (e) {
        let value = this.value.replace(/[^,\d]/g, '').toString();
        this.value = formatRupiah(value);
    });

    function formatRupiah(angka) {
        if (angka === null || angka === undefined) return '';

        let number;

        if (typeof angka === 'string') {
            // format DB: "100.00"
            if (angka.includes('.')) {
                number = Number(angka);   // langsung parse
            } 
            // format lokal: "100,00"
            else if (angka.includes(',')) {
                number = Number(angka.replace(',', '.'));
            } 
            else {
                number = Number(angka);
            }
        } else {
            number = Number(angka);
        }

        if (isNaN(number)) number = 0;

        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);
    }
    // END OF RUPIAH

    // GET DATA
    function getGudang()
    {
        return axios.get(urlGudang)
                .then((response) => {
                    let data = response.data;
                    let select = $('#gudang');

                    // console.log(response.data.data);
                    select.empty();

                    select.append('<option value="">-- Pilih Gudang --</option>');

                    data.forEach(parent => {
                        select.append(`<option value="${parent.kode_gudang}">${parent.nama_gudang}</option>`)
                    })
                    // console.log(data);
                })
                .catch((error) => {
                    console.error("Error Saat Get Data Gudang: ", error);
                    alert("Gagal Mengambil Data Gudang");
                });
    }

    function getBarang()
    {
        return axios.get(urlBarang)
                .then((response) => {
                    let data = response.data;
                    let select = $('#barang');

                    // console.log(response.data.data);
                    select.empty();

                    select.append('<option value="">-- Pilih Barang --</option>');

                    data.forEach(parent => {
                        select.append(`<option value="${parent.kode_barang}">${parent.nama_barang}</option>`)
                    })
                    // console.log(data);
                })
                .catch((error) => {
                    console.error("Error Saat Get Data Barang: ", error);
                    alert("Gagal Mengambil Data Barang");
                });
    }

    function getSatuan( )
    {
        return axios.get(urlSatuan)
                .then((response) => {
                    let data = response.data;
                    let select = $('#satuan');

                    // console.log(response.data.data);
                    select.empty();

                    select.append('<option value="">-- Pilih Satuan --</option>');

                    data.forEach(parent => {
                        select.append(`<option value="${parent.kode_satuan}">${parent.nama_satuan}</option>`)
                    })
                    // console.log(data);
                })
                .catch((error) => {
                    console.error("Error Saat Get Data Satuan: ", error);
                    alert("Gagal Mengambil Data Satuan");
                });
    }

    function getEdit(gudangstokid)
    {
        // console.log("sampek getEdit", gudangstokid);
        axios.get(urlEdit(gudangstokid))
            .then(res => {
                // response berupa list menu + hak akses
                renderData(res.data);
            })
            .catch(err => {
                console.error(err);
                alert('Gagal mengambil data saat mau edit stok');
            });
    }

    async function renderData(data)
    {
        // console.log(data);
        await getGudang();
        await getBarang();
        await getSatuan();

        if (!data || data.length === 0) {
            alert("Data tidak ditemukan, cek database!");
            return;
        }

        const item = data[0]; // karena response array
        
        modal.removeClass("hidden");
        document.getElementById('id').value = item.id;
        document.getElementById('gudang').value = item.kode_gudang;
        document.getElementById('barang').value = item.kode_barang;
        document.getElementById('satuan').value = item.kode_satuan;
        document.getElementById('harga').value  = formatRupiah(item.harga_barang);
        document.getElementById('stok').value   = item.stok_barang;
        document.getElementById('is_active').value = item.is_active ? '1' : '0';

        // buka modal
        modal.removeClass('hidden');
    }
    // END OF GET DATA

    // window.editStok = editStok;
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
                // { mData: no },
                { mData: "kode_permintaan" },
                { mData: "tanggal_permintaan" },
                { mData: "unitnama" },
                { mData: "total_harga" },
                { mData: "keterangan" },
                { mData: "nama" },
                { mData: "action" }
            ],
        });


        dataTabel = $("#tabel-data").DataTable();

        $('#searchbar').on('keyup', function () {
            dataTabel.search(this.value).draw();
        });
    };

    (() => {
        loadtable();
    })();
});
