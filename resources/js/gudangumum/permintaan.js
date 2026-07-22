
$(function () {
    let urlLoadData = '/permintaan/datatables';
    // let urlCariBarang = '/permintaan/cari-barang?term=${query}';
    let urlCariBarang = '/permintaan/cariBarang';
    // let urlSimpan = "{{ route('masterdokter.store') }}";
    let urlSimpan = '/stokgudang/simpan';
    let urlUpdate = '/stokgudang/update';
    let urlGudang = '/stokgudang/getGudang';
    let urlBarang = '/stokgudang/getBarang';
    let urlSatuan = '/stokgudang/getSatuan';
    let selectedBarang = null;

    const urlEdit = (id) => `/stokgudang/${id}/getEdit`;
    const urlgetLimit = (id) => `/permintaan/get-limit/${id}`;
    // const urlUpdate = (id) => `/stokgudang/${id}/update`;

    let dataTabel = $("#tabel-data");
    let modal = $("#modal-data");

    const inputHarga = document.getElementById('harga');

    let no = 1;


    // document.getElementById("btn-simpan").onclick = () => {

    // };

    // document.getElementById("btn-update").onclick = () => {

    // };

    // // UNTUK MENGEDIT STOK
    // $(document).on('click', '.btn-edit', function () {

    // });
    // const showModal = (method = "POST") => {

    // };


    const tambahModal = () => {
        $("#btn-simpan").text("Simpan"); // Mengubah text button 
        $("#btn-simpan").show();
        $("#btn-update").hide();
    }

    function updateUnitLimit() {
        const unitId = $('#unit_id').val();
        const limitDisplay = $('#unit-limit');
        console.log(unitId);
        if (!unitId) {
            limitDisplay.text('Rp 0');
            return;
        }

        axios.get(urlgetLimit(unitId))
            .then(response => {
                limitDisplay.text(response.data.formatted);
            })
            .catch(error => {
                console.error("Error fetching unit limit:", error);
                limitDisplay.text('Error');
            });
    }

    $('#nama-barang').on('keyup', function () {
        let keyword = $(this).val();

        if (keyword.length < 2) {
            $('#suggestion-box').hide();
            return;
        }

        $.ajax({
            url: urlCariBarang,
            type: 'GET',
            data: { term: keyword },
            success: function (response) {
                console.log(response);
                let html = '';

                response.forEach(item => {
                    html += `
                        <div class="p-2 cursor-pointer hover:bg-gray-100 suggestion-item"
                            data-id="${item.id}"
                            data-nama="${item.text}"
                            data-harga="${item.harga_barang}">
                            ${item.text}
                        </div>
                    `;
                });

                $('#suggestion-box').html(html).show();
            }
        });
    });

    // klik suggestion
    $(document).on('click', '.suggestion-item', function () {
        let nama = $(this).data('nama');
        let id = $(this).data('id');
        let harga = $(this).data('harga');

        $('#nama-barang').val(nama);
        $('#suggestion-box').hide();

        selectedBarang = {
            id: id,
            nama: nama,
            harga: harga
        };
    });

    $(document).on('keyup change', '.harga, .jumlah', function () {

        let row = $(this).closest('tr');

        let harga = parseFloat(row.find('.harga').val()) || 0;
        let jumlah = parseFloat(row.find('.jumlah').val()) || 0;

        let subtotal = harga * jumlah;

        row.find('.subtotal').text(subtotal.toLocaleString());
    });

    $(document).on('click', '.btn-hapus', function () {
        $(this).closest('tr').remove();
    });

    // tombol tambah barang
    $('#btn-tambah').on('click', function () {

        if (!selectedBarang) {
            alert('Pilih barang dulu');
            return;
        }
        console.log(selectedBarang);
        let row = `
            <tr>
                <td class="border p-2">${selectedBarang.nama}</td>
                <td class="border p-2">
                    <input type="number" readonly class="harga w-full border rounded p-1" value="${selectedBarang.harga}">
                </td>
                <td class="border p-2">
                    <input type="number" class="jumlah w-full border rounded p-1" value="1">
                </td>
                <td class="border p-2 text-right subtotal">0</td>
                <td class="border p-2 text-center">
                    <button class="btn-hapus text-red-500">Hapus</button>
                </td>
            </tr>
        `;

        $('#tabel-barang').append(row);

        $('#nama-barang').val('');
        selectedBarang = null;
    });


    const editModal = () => {
        $("#btn-update").text("Update"); // Mengubah text button 
        $("#btn-update").show();
        $("#btn-simpan").hide();

    }



    const simpanData = (gudang, barang, satuan, harga, stok, isActive) => {

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
        document.getElementById('gudang').disabled = false;
        document.getElementById('barang').disabled = false;
        document.getElementById('satuan').disabled = false;

        document.getElementById('gudang').value = '';
        document.getElementById('barang').value = '';
        document.getElementById('satuan').value = '';
        document.getElementById('harga').value = '';
        document.getElementById('stok').value = '';
        document.getElementById('is_active').value = '1';
    };

    const readOnly = () => {
        document.getElementById('gudang').disabled = true;
        document.getElementById('barang').disabled = true;
        document.getElementById('satuan').disabled = true;
    }

    const checkdata = () => {
        const id = document.getElementById('id').value;
        const gudang = document.getElementById('gudang').value;
        const barang = document.getElementById('barang').value;
        const satuan = document.getElementById('satuan').value;
        const hargaRaw = document.getElementById('harga').value;
        const stok = document.getElementById('stok').value;
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


    async function renderData(data) {
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
        document.getElementById('harga').value = formatRupiah(item.harga_barang);
        document.getElementById('stok').value = item.stok_barang;
        document.getElementById('is_active').value = item.is_active ? '1' : '0';

        // buka modal
        modal.removeClass('hidden');
    }
    // END OF GET DATA
    // console.log("Script permintaan.js terpanggil!");
    document.addEventListener('DOMContentLoaded', function () {
        const inputBarang = document.getElementById('nama-barang');
        const suggestionBox = document.getElementById('suggestion-box');


        if (inputBarang) {
            console.log("Elemen input ditemukan!");

            inputBarang.addEventListener('input', function () {
                console.log("User mengetik: " + this.value);
                // ... kode fetch kamu ...
            });
        } else {
            console.error("Elemen nama-barang TIDAK ditemukan di DOM");
        }
        inputBarang.addEventListener('input', function () {
            let query = this.value;

            if (query.length < 2) {
                suggestionBox.classList.add('hidden');
                return;
            }

            // Ganti URL sesuai route yang kamu buat
            fetch(`/permintaan/cari-barang?term=${query}`)
                .then(response => response.json())
                .then(data => {
                    suggestionBox.innerHTML = '';
                    if (data.length > 0) {
                        suggestionBox.classList.remove('hidden');
                        data.forEach(item => {
                            const div = document.createElement('div');
                            div.innerHTML = item.text;
                            div.className = 'px-4 py-2 hover:bg-blue-100 cursor-pointer text-sm';

                            div.addEventListener('click', function () {
                                inputBarang.value = item.text;
                                // Jika butuh ID-nya, kamu bisa simpan di hidden input
                                // document.getElementById('id-barang').value = item.id;
                                suggestionBox.classList.add('hidden');
                            });
                            suggestionBox.appendChild(div);
                        });
                    } else {
                        suggestionBox.classList.add('hidden');
                    }
                });
        });

        // Sembunyikan suggest saat klik di luar
        document.addEventListener('click', function (e) {
            if (!inputBarang.contains(e.target)) {
                suggestionBox.classList.add('hidden');
            }
        });
    });



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
        // Trigger update on load and change
        updateUnitLimit();
        $('#unit_id').on('change', updateUnitLimit);
    })();
});
