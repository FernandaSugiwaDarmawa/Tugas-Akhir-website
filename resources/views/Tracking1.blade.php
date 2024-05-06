<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kereta Api</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; /* Warna latar belakang */
            margin: 0;
            padding: 0;
        }
        .container {
            text-align: center;
            max-width: 100%; /* Menetapkan lebar maksimum untuk kontainer */
            position: relative; /* Tambahkan posisi relatif untuk kontainer */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            overflow: auto; /* Membuat tabel dapat discroll */
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .clock {
            font-size: 20px;
            margin-bottom: 10px;
            color: #007bff;
            text-align: center; /* Letakkan jam di tengah */
        }
        /* Menandai baris dengan warna merah */
        .blocked-row {
            background-color: #ffcccc;
        }
        /* Meratakan teks di tengah untuk waktu keberangkatan dan kedatangan */
        td:nth-child(3),
        td:nth-child(4) {
            text-align: left; /* Mengatur teks jam ke kiri */
        }
        /* Animasi teks berkedip */
        .blinking-text {
            animation: blink-animation 1s steps(5, start) infinite;
        }
        @keyframes blink-animation {
            to {
                visibility: hidden;
            }
        }
        /* Tambahkan gaya untuk membuat tabel fullscreen */
        .full-width-table {
            width: 100%;
            max-width: none;
            margin-left: auto;
            margin-right: auto;
        }
        /* Gaya untuk tombol "Kembali ke Halaman Utama" */
        .back-to-home {
            position: fixed;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
        }
        .train-link {
            text-decoration: underline;
            color: blue;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Jadwal Kereta Api</h2>
    <div class="clock" id="clock"></div>
    <!-- Teks berkedip -->
    <div class="blinking-text" id="trainInfo"></div>
    <div style="overflow-x:auto;">
        <table class="full-width-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Stasiun</th>
                    <th>Waktu Kedatangan</th>
                    <th>Waktu Keberangkatan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Stasiun Mojokerto</td>
                    <td>06:00</td>
                    <td>06:47</td>
                    <td id="status1">Tiba</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Stasiun Sidoarjo</td>
                    <td>07:05</td>
                    <td>07:46</td>
                    <td id="status2">Berangkat</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Stasiun Mojokerto</td>
                    <td>08:10</td>
                    <td>09:13</td>
                    <td id="status3">Berangkat</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Stasiun Surabaya Gubeng</td>
                    <td>16:14</td>
                    <td>17:35</td>
                    <td id="status4">Tiba</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Stasiun Sidoarjo</td>
                    <td>18:05</td>
                    <td>18:45</td>
                    <td id="status5">Tiba</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Stasiun Sidoarjo</td>
                    <td>23:48</td>
                    <td>19:29</td>
                    <td id="status6">Tiba</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<a class="back-to-home" href="{{ route('index') }}">Kembali ke Halaman Utama</a>

<!-- Script untuk menampilkan jam dan menandai baris dengan warna merah -->
<script>
    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('clock').innerHTML = h + ":" + m + ":" + s;
        var t = setTimeout(startTime, 1000);

        // Update status based on current time
        var departureTimes = document.querySelectorAll('tbody tr');
        departureTimes.forEach(function(row) {
            var arrivalTime = row.querySelector('td:nth-child(3)').innerText;
            var departureTime = row.querySelector('td:nth-child(4)').innerText;

            var [arrivalHour, arrivalMinute] = arrivalTime.split(':');
            var [departureHour, departureMinute] = departureTime.split(':');

            if (parseInt(arrivalHour) === h && parseInt(arrivalMinute) === m) {
                row.querySelector('td:nth-child(5)').innerText = 'Tiba';
            } else if (parseInt(departureHour) === h && parseInt(departureMinute) === m) {
                row.querySelector('td:nth-child(5)').innerText = 'Berangkat';
            }
        });
    }

    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }
    startTime();

    // Teks berkedip untuk kereta yang sedang beroperasi saat ini
    function updateTrainInfo() {
        var today = new Date();
        var currentHour = today.getHours();
        var currentMinute = today.getMinutes();
        var trainInfo = document.getElementById('trainInfo');
        var trainSchedule = [
            { name: 'Stasiun Mojokerto', arrivalTime: '13:11', departureTime: '06:47' },
            { name: 'Stasiun Sidoarjo', arrivalTime: '07:05', departureTime: '07:46' },
            { name: 'Stasiun Mojokerto', arrivalTime: '08:10', departureTime: '09:13' },
            { name: 'Stasiun Surabaya Gubeng', arrivalTime: '16:14', departureTime: '17:35' },
            { name: 'Stasiun Sidoarjo', arrivalTime: '18:05', departureTime: '18:45' },
            { name: 'Stasiun Sidoarjo', arrivalTime: '23:48', departureTime: '19:29' }
        ];

        // Mencari kereta yang sedang beroperasi saat ini
        var currentTrain = null;
        for (var i = 0; i < trainSchedule.length; i++) {
            var train = trainSchedule[i];
            var [departureHour, departureMinute] = train.departureTime.split(':');
            if (parseInt(departureHour) === currentHour && parseInt(departureMinute) <= currentMinute) {
                currentTrain = train;
                break;
            }
        }

        // Memperbarui teks berkedip
        if (currentTrain) {
            trainInfo.innerHTML = `${currentTrain.name} berangkat pada jam ${currentTrain.departureTime} dan tiba pada jam ${currentTrain.arrivalTime}`;
            trainInfo.classList.add('blinking-text');
        } else {
            trainInfo.innerHTML = ''; // Jika tidak ada kereta yang sedang beroperasi, kosongkan teks berkedip
            trainInfo.classList.remove('blinking-text');
        }
    }

    // Memperbarui teks berkedip setiap detik
    setInterval(updateTrainInfo, 1000);
</script>

</body>
</html>
