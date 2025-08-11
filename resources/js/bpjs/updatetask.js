$(function () {
    let urlPostTask = "/BPJS/updatetask/postTask";
    let urlCariData = "/BPJS/updatetask/getKodeBooking";
    let urlPost = "/BPJS/updatetask/postTask";
    let urlPostAddAntrean = "/BPJS/updatetask/postAddAntrean";
    let urlPostBatal = "/BPJS/updatetask/batal";
    let urlSimpan = "/BPJS/tasklist/simpan";
    let urlAntrean = "/BPJS/updatetask/antrean";
    let urlCariDataTask6 = "/BPJS/updatetask/getTask6"
    let urlCariDataSelisih = '/BPJS/updatetask/getSelisih'
    let urlJadwalDokterPoli = '/BPJS/updatetask/getJadwalDokterPoli'
    let urlGetPoliklinik = '/BPJS/updatetask/getPoliklinik'
    let urlGetAntrianPoliklinik = '/BPJS/updatetask/getAntrianPoliklinik'

    let jadwal = null;
    let kapasitas = null;
    let kodepoli = null;
    let nomorantrian = null;
    let mulaikonsul = null;
    let selesaikonsul = null;
    let kapasitasjkn = null;
    let subjadwal = null;
    let waktuestimasi = null;
    const today = new Date();
    

    //import { simpanData } from './tasklist.js';
    // Initisalisasi
    let dataTabel = $("#tabel-data");
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    let formModal = $("#form-data");
    
    document.getElementById("btn-update").onclick = () => {
        const kodebooking = document.getElementById("kodebooking").value;
        const taskid = document.getElementById('taskid').value;

        console.log("Pencarian Taskid " + taskid);
        const caritask = taskid - 1;

        console.log(caritask);

        cariData(kodebooking, caritask);

        // postTask(kodebooking, taskid)
        
    };

    document.getElementById("btn-update-error").onclick = () => {
        const kodebooking = document.getElementById("kodebooking").value;
        const taskid = document.getElementById('taskid').value;

        console.log("Pencarian Taskid " + taskid);
        const caritask = taskid;

        console.log(caritask);

        cariDataError(kodebooking, caritask);

        // postTask(kodebooking, taskid)
        
    };

    document.getElementById("btn-add").onclick = () => {
        const kodebooking = document.getElementById("kodebooking").value;
        const taskid = document.getElementById('taskid').value;

        console.log("Add Task " + kodebooking);
        const caritask = taskid;

        // console.log(caritask);

        AddTask3(kodebooking, caritask);

        // postTask(kodebooking, taskid)
        
    };

    document.getElementById("btn-addAntrean").onclick = () => {
        const kodebooking = document.getElementById("kodebooking").value;
        const taskid = document.getElementById('taskid').value;

        console.log("Add Antrean " + kodebooking);
        const caritask = taskid;

        // console.log(caritask);

        AddAntrean(kodebooking, caritask);

        // postTask(kodebooking, taskid)
        
    };

    document.getElementById("btn-batalAntrean").onclick = () => {
        const kodebooking = document.getElementById("kodebooking").value;
        
        console.log("Batal  " + kodebooking);

        // batalAntrean(kodebooking);
        postBatal(kodebooking);
        
    };

    async function getJadwalDokterPoli(kddpjp, tanggal) {
        try {
            const res = await axios.get(urlJadwalDokterPoli, {
                params: { kddpjp: kddpjp, tanggal: tanggal }
            });
            console.log(res.data);
            if (Object.keys(res.data).length > 0) {
                return res.data;
            } else {
                alert("Error Jadwal Dokter Poli");
                return null;
            }
        } catch (err) {
            if (err.response && err.response.status !== 200) {
                alert("Gagal Jadwal Dokter Poli");
            } else {
                console.error("Terjadi kesalahan JadwalDokterPoli:", err.message);
            }
            return null;
        }
    }

    async function getPoliklinik(namapoli) {
        try {
            const res = await axios.get(urlGetPoliklinik, {
                params: { namapoli: namapoli}
            });
            console.log(res.data);
            if (Object.keys(res.data).length > 0) {
                return res.data;
            } else {
                alert("Error Get Poli");
                return null;
            }
        } catch (err) {
            if (err.response && err.response.status !== 200) {
                alert("Gagal Get Poli");
            } else {
                console.error("Terjadi kesalahan Get Poli:", err.message);
            }
            return null;
        }
    }

    async function getAntrianPoliklinik(nomr, tanggal) {
        try {
            const res = await axios.get(urlGetAntrianPoliklinik, {
                params: { nomr:nomr, tanggal:tanggal}
            });
            console.log(res.data);
            if (Object.keys(res.data).length > 0) {
                return res.data;
            } else {
                alert("Error Get Antrian Poli");
                return null;
            }
        } catch (err) {
            if (err.response && err.response.status !== 200) {
                alert("Gagal Get Antrian Poli");
            } else {
                console.error("Terjadi kesalahan Get Antrian Poli:", err.message);
            }
            return null;
        }
    }

    // function getJadwalDokterPoli(kddpjp, tanggal)
    // {
    //     return new Promise((resolve, reject) => {
    //     axios
    //         .get(urlJadwalDokterPoli, {
    //             params: {
    //                 kddpjp:kddpjp,
    //                 tanggal:tanggal
    //             }
    //         })
    //         .then(function (res) {
    //             // console.log(res.data);
    //             // throw new Error("jadwal dokter poli sengaja error");
    //             if (res.data.length > 0) {
    //                 return res.data; 
    //             } else {
    //                 alert("Error Jadwal Dokter Poli");
    //             }
    //         })
    //         .catch(function (err) {
    //             if (err.response && err.response.status !== 200) {
    //                 alert("Gagal Jadwal Dokter Poli");
    //             } else {
    //                 console.error("Terjadi kesalahan JadwalDokterPoli:", err.message);
    //             }
    //         });
    //     });
    // }
    function getRandomTime(minMinutes, maxMinutes) {
        const minMs = minMinutes * 60 * 1000; // Mengubah menit ke milisecond
        const maxMs = maxMinutes * 60 * 1000; // Mengubah menit ke milisecond
        return Math.floor(Math.random() * (maxMs - minMs + 1)) + minMs;
    }

    function convertTimestampToDate(timestamp) {
        
        const [datePart, timePart] = timestamp.split(' ');
        const [day, month, year] = datePart.split('-');
        const [hour, minute, second] = timePart.split(':');
    
        return new Date(`${year}-${month}-${day}T${hour}:${minute}:${second}`);
    }

    function addMillisecondsToTimestamp(timestamp, milliseconds) {
        let date = convertTimestampToDate(timestamp);
        return date.getTime() + milliseconds;
    }

    function minusMillisecondsToTimestamp(timestamp, milliseconds) {
        let date = convertTimestampToDate(timestamp);
        return date.getTime() - milliseconds;
    }

    function cariData(kodebooking, caritask)
    {
        //const kodebooking = kodebooking;
        console.log(kodebooking);
        axios
            .get(urlCariData, {
                params: {
                    kodebooking:kodebooking,
                    caritask:caritask
                }
            })
            .then(function (res) {
                console.log(res.data);
                const taskid = caritask + 1;
                if (res.data.length > 0) {
                    const waktu = res.data[0].wakturs;
                    const tanggal = res.data[0].tanggal_data;
                    const waktu2 = waktu.substring(0,19);
                    console.log('Task id: ' + taskid);
                    const newTime = pembagianWaktu(waktu2, taskid);
                    console.log('New Time pada cariData ' +  newTime);
                    postTask(kodebooking, taskid, newTime, tanggal);

                } else {
                    alert("Update Task " + taskid + " Gagal, Taskid " + caritask + " Tidak Ditemukan");
                }
            })
            .catch(function (err) {
                if (err.response && err.response.status !== 200) {
                    alert("Gagal Pencarian Kode Booking Update Task");
                } else {
                    console.error("Terjadi kesalahan CariData:", err.message);
                }
            });
    }

    function cariDataError(kodebooking, caritask)
    {
        //const kodebooking = kodebooking;
        console.log(kodebooking);
        axios
            .get(urlCariData, {
                params: {
                    kodebooking:kodebooking,
                    caritask:caritask
                }
            })
            .then(function (res) {
                console.log(res.data);
                const taskid = caritask
                if (res.data.length > 0) {
                    const waktu = res.data[0].wakturs;
                    const tanggal = res.data[0].tanggal_data;
                    const waktu2 = waktu.substring(0,19);
                    console.log('Task id: ' + taskid);
                    const newTime = pembagianWaktu(waktu2, taskid);
                    console.log('New Time pada cariData ' +  newTime);
                    postTask(kodebooking, taskid, newTime, tanggal);

                } else {
                    alert("Update Task " + taskid + " Gagal, Taskid " + caritask + " Tidak Ditemukan");
                }
            })
            .catch(function (err) {
                if (err.response && err.response.status !== 200) {
                    alert("Gagal Pencarian Kode Booking Update Task");
                } else {
                    console.error("Terjadi kesalahan CariData:", err.message);
                }
            });
    }


    function AddTask3(kodebooking, caritask)
    {
        //const kodebooking = kodebooking;
        console.log(kodebooking);
        axios
            .get(urlCariDataTask6, {
                params: {
                    kodebooking:kodebooking,
                    caritask: caritask
                }
            })
            .then(function (res) {
                console.log(res.data);
                if (res.data.length > 0) {
                    const randomTime = getRandomTime(40, 50);
                    const tanggal = res.data[0].tanggal_data;
                    const waktu = res.data[0].wakturs;
                    const waktu2 = waktu.substring(0,19);
                    const taskid = 3;
                    const newTime = minusMillisecondsToTimestamp(waktu2, randomTime);
                    console.log(kodebooking, randomTime, newTime, tanggal);
                    //throw new Error("Stopping script execution");
                    postTask(kodebooking, taskid, newTime, tanggal);
                } else {
                    alert("Data Antrean " + kodebooking + " Tidak Ditemukan");
                }
            })
            .catch(function (err) {
                if (err.response && err.response.status !== 200) {
                    alert("Gagal Pencarian Kode Booking Update Task");
                } else {
                    console.error("Terjadi kesalahan CariData:", err.message);
                }
            });
    }

    function batalAntrean(kodebooking)
    {

    }

    // async function AddAntrean(kodebooking, caritask)
    // {
    //     //const kodebooking = kodebooking;
    //     console.log(kodebooking);
    //     axios
    //         .get(urlCariDataSelisih, {
    //             params: {
    //                 kodebooking:kodebooking
    //             }
    //         })
    //         .then(function (res) {
    //             //console.log(res.data);
    //             //throw new Error("add antrean sengaja error");
    //             if (res.data.length > 0) {
    //                 const tanggal = new Date().toISOString().split('T')[0];
    //                 const dataAntrean = res.data[0];
    //                 const nokartu = dataAntrean.nokartu;
    //                 const nomr = dataAntrean.nomr;
    //                 const poli = dataAntrean.poli;
    //                 const nama = dataAntrean.nama;
    //                 const kddpjp = dataAntrean.kddpjp;
    //                 const nmdpjp = dataAntrean.nmdpjp;
    //                 const norujukan = dataAntrean.norujukan;
                    
    //                 // DATA JOIN DARI TABEL PESERTA
    //                 const pesertaData = dataAntrean.peserta[0];
    //                 const nik = pesertaData.nik;
    //                 const nohp = pesertaData.noTelepon;

    //                 const jadwalpoli = await getJadwalDokterPoli(kddpjp, tanggal);
    //                 console.log(tanggal, jadwalpoli, nokartu,nomr,poli,nama,kddpjp,nmdpjp,norujukan,nik, nohp, dataAntrean.peserta);
    //                 throw new Error("add antrean sengaja error");

                    
    //             } else {
    //                 alert("Data Antrean " + kodebooking + " Tidak Ditemukan");
    //             }
    //         })
    //         .catch(function (err) {
    //             if (err.response && err.response.status !== 200) {
    //                 alert("Gagal Pencarian Kode Booking Update Task");
    //             } else {
    //                 console.error("Terjadi kesalahan CariData:", err.message);
    //             }
    //         });
    // }

    async function AddAntrean(kodebooking, caritask){
        try {
            console.log(kodebooking);

            const res = await axios.get(urlCariDataSelisih, {
                params: {kodebooking: kodebooking}
            });
            if (res.data.length > 0) {
                const tanggal = new Date().toISOString().split('T')[0];
                // const tanggal = '2024-11-26';
                const dataAntrean = res.data[0];
                const nokartu = dataAntrean.nokartu;
                const nomr = dataAntrean.nomr;
                const namapoli = dataAntrean.poli;
                const nama = dataAntrean.nama;
                const kddpjp = dataAntrean.kddpjp;
                const nmdpjp = dataAntrean.nmdpjp;
                const norujukan = dataAntrean.norujukan;
                
                // DATA JOIN DARI TABEL PESERTA
                const pesertaData = dataAntrean.peserta[0];
                const nik = pesertaData.nik;
                const nohp = pesertaData.noTelepon;

                

                // GET JADWAL POLI
                const jadwalpoli = await getJadwalDokterPoli(kddpjp, tanggal);
                if (jadwalpoli) {
                    // console.log(tanggal, jadwalpoli.jadwal, nokartu, nomr, poli, nama, kddpjp, nmdpjp, norujukan, nik, nohp, dataAntrean.peserta);
                    jadwal = jadwalpoli.jadwal;
                    kapasitas = jadwalpoli.kapasitas;
                } else {
                    alert("Jadwal Dokter Poli tidak ditemukan.");
                }
                
                // GET KODE POLI
                const poli = await getPoliklinik(namapoli);
                if (poli) {
                    kodepoli = poli.kodepoli;
                } else {
                    alert("Get Poliklinik tidak ditemukan.");
                }

                // GET ANTRIAN POLI
                const antrian = await getAntrianPoliklinik(nomr, tanggal);
                if (antrian) {
                    nomorantrian = antrian.nomorantrian;
                    mulaikonsul = antrian.mulaikonsul;
                    selesaikonsul = antrian.selesaikonsul;
                } else {
                    alert("Get Poliklinik tidak ditemukan.");
                }
                // console.log(nomorantrian);
                // MANIPULASI NOMOR ANTRIAN
                // waktuestimasi
                if (nomorantrian > kapasitas)
                {
                    kapasitasjkn = kapasitas - 1;
                    nomorantrian = getRandomInt(1, kapasitasjkn);
                }

                // MEMBUAT ESTIMASI
                subjadwal = jadwal.substring(0, 5);
                const tanggalEstimasi = `${today.getDate().toString().padStart(2, '0')}-${(today.getMonth() + 1).toString().padStart(2, '0')}-${today.getFullYear()}`;
                waktuestimasi = `${tanggalEstimasi} ${subjadwal}:00`;
                const randomTime = getRandomTime(4, 30);
                const newTime = addMillisecondsToTimestamp(waktuestimasi, randomTime);

                const kapasita2 = kapasitas - 1;
                const sisa = getRandomInt(1, kapasita2);
                
                postAddAntrean(
                    kodebooking,
                    nokartu,
                    nik,
                    nohp,
                    kodepoli,
                    namapoli,
                    nomr,
                    tanggal,
                    kddpjp,
                    nmdpjp,
                    jadwal,
                    norujukan,
                    nomorantrian,
                    newTime,
                    sisa,
                    kapasitas
                )

                console.log(sisa, newTime, waktuestimasi, tanggal, tanggalEstimasi, jadwal, subjadwal, kapasitas, kapasitasjkn, kodepoli, nomorantrian);
                // throw new Error("add antrean sengaja error");
            } else {
                alert("Data Antrean " + kodebooking + " Tidak Ditemukan");
            }

        } catch (err) {
            if (err.response && err.response.status !== 200) {
                alert("Gagal Pencarian Kode Booking Update Task");
            } else {
                console.error("Terjadi kesalahan CariData:", err.message);
            }
        }
    }

    function postAddAntrean(
        kodebooking,
        nokartu,
        nik,
        nohp,
        kodepoli,
        namapoli,
        nomr,
        tanggal,
        kddpjp,
        nmdpjp,
        jadwal,
        norujukan,
        nomorantrian,
        newTime,
        sisa,
        kapasitas
    )
    {
        axios
            .post(urlPostAddAntrean, {
                kodebooking: kodebooking,
                nokartu: nokartu,
                nik: nik,
                nohp: nohp,
                kodepoli: kodepoli,
                namapoli: namapoli,
                nomr: nomr,
                tanggal: tanggal,
                kddpjp: kddpjp,
                nmdpjp: nmdpjp,
                jadwal: jadwal,
                norujukan: norujukan,
                nomorantrian: nomorantrian,
                newTime: newTime,
                sisa: sisa,
                kapasitas: kapasitas
            })
            .then(function (res) {
                if (res.status === 200) {
                    console.log("Antrean Berhasil Ditambahkan:", res.data);
                    // Panggil fungsi lain jika diperlukan
                    alert("Antrean berhasil ditambahkan!");
                } else {
                    alert("Penambahan Antrean Gagal");
                }
            })
            .catch(function (err) {
                if (err.response && err.response.status !== 200) {
                    alert("Error pada Penambahan Antrean");
                } else {
                    console.error("Terjadi Kesalahan:", err.message);
                }
            });
    }

    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function pembagianWaktu (waktu2, taskid)
    {
        const caritask = taskid + 1;
        console.log("Cari tAsk " + caritask);
        console.log("taskid " + taskid);

        if (taskid == 1)
        {
            const randomTime = getRandomTime(1, 3);
            console.log("Random TIme: " + randomTime);
            const newTime = addMillisecondsToTimestamp(waktu2, randomTime);
            console.log("Waktu Update Task " + taskid + " Adalah " + newTime);
            return newTime;
        }
        else  if (taskid == 2)
        {
            const randomTime = getRandomTime(1, 3);
            console.log("Random TIme: " + randomTime);
            const newTime = addMillisecondsToTimestamp(waktu2, randomTime);
            console.log("Waktu Update Task " + taskid + " Adalah " + newTime);
            return newTime;
        }
        else  if (taskid == 3)
        {
            const randomTime = getRandomTime(2, 4);
            console.log("Random TIme: " + randomTime);
            const newTime = addMillisecondsToTimestamp(waktu2, randomTime);
            console.log("Waktu Update Task " + taskid + " Adalah " + newTime);
            return newTime;
        }
        else  if (taskid == 4)
        {
            const randomTime = getRandomTime(20, 40);
            console.log("Random TIme: " + randomTime);
            const newTime = addMillisecondsToTimestamp(waktu2, randomTime);
            console.log("Waktu Update Task " + taskid + " Adalah " + newTime);
            return newTime;
        }
        else  if (taskid == 5)
        {
            const randomTime = getRandomTime(5, 10);
            console.log("Random TIme: " + randomTime);
            const newTime = addMillisecondsToTimestamp(waktu2, randomTime);
            console.log("Waktu Update Task " + taskid + " Adalah " + newTime);
            return newTime;
        }
        else  if (taskid == 6)
        {
            const randomTime = getRandomTime(3, 6);
            console.log("Random TIme: " + randomTime);
            const newTime = addMillisecondsToTimestamp(waktu2, randomTime);
            console.log("Waktu Update Task " + taskid + " Adalah " + newTime);
            return newTime;
        }
        else  if (taskid == 7)
        {
            const randomTime = getRandomTime(7, 15);
            console.log("Random TIme: " + randomTime);
            const newTime = addMillisecondsToTimestamp(waktu2, randomTime);
            console.log("Waktu Update Task " + taskid + " Adalah " + newTime);
            return newTime;
        }
    }
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

    const postTask = (kodebooking, taskid, newTime, tanggal) => {
        console.log("post Task " + kodebooking, taskid, newTime);
        axios
            .post(urlPost, {
                kodebooking: kodebooking,
                taskid: taskid,
                newTime: newTime
            })
            .then(function (res) {
                if (res.status === 200) {
                console.log(res);
                    simpanData(kodebooking, tanggal); 
                    console.log("Post Task Berhasil");

                } else {
                    alert("Post Task Data Gagal");
                }
            })
            .catch(function (err) {
                if (err.response && err.response.status !== 200) {
                    alert("Error Pada Post Task");
                } else {
                    console.error("Terjadi kesalahan Pada SimpanData:", err.message);
                }
            });
    };

    const postBatal = (kodebooking) => {
        console.log("post batal "+ kodebooking );
        axios
            .post(urlPostBatal, {
                kodebooking: kodebooking
            })
            .then(function (res) {
                if (res.status === 200) {
                console.log(res);
                alert("Pembatalan Kodebooking Berhasil");
                } else {
                    alert("Pembatalan Kodebooking Gagal");
                }
            })
            .catch(function (err) {
                if (err.response && err.response.status !== 200) {
                    alert("Error Pada Post Batal");
                } else {
                    console.error("Terjadi kesalahan Pada SimpanData:", err.message);
                }
            });

    }
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
