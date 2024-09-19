<!DOCTYPE html>
<html>
<head>
    <title>Digital Clock</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta http-equiv="refresh" content="10"> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* .clock {
            font-family: 'Arial', sans-serif;
            color: #333;
            font-size: 48px;
            text-align: center;
            padding: 20px;
            margin-top: 20%;
        } */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }

        .container {
            text-align: center;
        }

        .clock {
            font-size: 48px;
            color: #333;
            padding: 20px;
        }

        .h1 {
            margin: 0;
            font-size: 24px;
        }
    </style>
</head>
<body>
    
    <h1 class="h1">Mohon Tidak Ditutup</h1><br>
    <h1 class="h1">Halaman Untuk Get Antrian Tanggal</h1><br>
    <h1 id="clock" class="clock"></h1>
    <br><br>
    <h1 class="h1">Antrian Akan Di Proses Pukul: 22.03 WIB</h1><br>

    <script>
        function updateClock() {
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();

            // Format jam, menit, dan detik agar selalu 2 digit
            if (hours < 10) hours = "0" + hours;
            if (minutes < 10) minutes = "0" + minutes;
            if (seconds < 10) seconds = "0" + seconds;

            // Tampilkan jam
            var timeString = hours + ":" + minutes + ":" + seconds;
            document.getElementById('clock').innerHTML = timeString;

            // Mengecek apakah sudah jam 15:00
            if (hours == "11" && minutes == "40" && seconds == "00") {
                // Redirect ke route updatetask.autoupdate
                window.location.href = "{{ route('antrianonline.autostore') }}";
            } else if (hours == "12" && minutes == "45" && seconds == "00") {
                // Redirect ke route updatetask.autoupdate
                window.location.href = "{{ route('antrianonline.autostore') }}";
            } else if (hours == "16" && minutes == "00" && seconds == "00") {
                // Redirect ke route updatetask.autoupdate
                window.location.href = "{{ route('antrianonline.autostore') }}";
            } else if (hours == "22" && minutes == "03" && seconds == "00") {
                // Redirect ke route updatetask.autoupdate
                window.location.href = "{{ route('antrianonline.autostore') }}";
            } else if (hours == "22" && minutes == "15" && seconds == "00") {
                // Redirect ke route updatetask.autoupdate
                window.location.href = "{{ route('antrianonline.autostore') }}";
            } 
            
        }

        

        // Update clock setiap 1 detik
        setInterval(updateClock, 1000);

        // Panggil fungsi untuk menampilkan jam ketika halaman dimuat pertama kali
        updateClock();
    </script>
</body>
</html>
