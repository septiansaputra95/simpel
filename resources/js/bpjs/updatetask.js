$(function () {
    let urlPostTask = "/BPJS/updatetask/postTask";
    let urlCariData = "/BPJS/updatetask/getKodeBooking"
    let urlPost = "/BPJS/updatetask/postTask"
    let urlSimpan = "/BPJS/tasklist/simpan";
    

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
                const taskid = caritask + 1
                if (res.data.length > 0) {
                    const waktu = res.data[0].waktu;
                    const waktu2 = waktu.substring(0,19);
                    console.log(waktu2);
                    const newTime = pembagianWaktu(waktu2, taskid);
                    console.log('New Time pada cariData ' +  newTime);
                    postTask(kodebooking, taskid, newTime);

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

    function pembagianWaktu (waktu2, taskid)
    {
        const caritask = taskid + 1;
        if (taskid == 2)
        {
            const randomTime = getRandomTime(1, 3);
            console.log("Random TIme: " + randomTime);
            const newTime = addMillisecondsToTimestamp(waktu2, randomTime);
            console.log("Waktu Update Task " + caritask + " Adalah " + newTime);
            return newTime;
        }
        else  if (taskid == 3)
        {
            const randomTime = getRandomTime(2, 4);
            console.log("Random TIme: " + randomTime);
            const newTime = addMillisecondsToTimestamp(waktu2, randomTime);
            console.log("Waktu Update Task " + caritask + " Adalah " + newTime);
            return newTime;
        }
        else  if (taskid == 4)
        {
            const randomTime = getRandomTime(20, 45);
            console.log("Random TIme: " + randomTime);
            const newTime = addMillisecondsToTimestamp(waktu2, randomTime);
            console.log("Waktu Update Task " + caritask + " Adalah " + newTime);
            return newTime;
        }
        else  if (taskid == 5)
        {
            const randomTime = getRandomTime(5, 10);
            console.log("Random TIme: " + randomTime);
            const newTime = addMillisecondsToTimestamp(waktu2, randomTime);
            console.log("Waktu Update Task " + caritask + " Adalah " + newTime);
            return newTime;
        }
        else  if (taskid == 6)
        {
            const randomTime = getRandomTime(3, 6);
            console.log("Random TIme: " + randomTime);
            const newTime = addMillisecondsToTimestamp(waktu2, randomTime);
            console.log("Waktu Update Task " + caritask + " Adalah " + newTime);
            return newTime;
        }
        else  if (taskid == 7)
        {
            const randomTime = getRandomTime(7, 15);
            console.log("Random TIme: " + randomTime);
            const newTime = addMillisecondsToTimestamp(waktu2, randomTime);
            console.log("Waktu Update Task " + caritask + " Adalah " + newTime);
            return newTime;
        }

    }
    const simpanData = (kodebooking) => {
        axios
            .get(urlSimpan, {
                params: {
                    kodebooking:kodebooking
                }
            })
            .then(function (res) {
                // console.log(res);
                console.log("simpanData");
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

    const postTask = (kodebooking, taskid, newTime) => {
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
                    simpanData(kodebooking); 
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
