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
        }
        /* Menandai baris dengan warna merah */
        .blocked-row {
            background-color: #ffcccc;
        }
        /* Meratakan teks di tengah untuk waktu keberangkatan dan kedatangan */
        td:nth-child(5),
        td:nth-child(6),
        td:nth-child(7) {
            text-align: center;
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
                    <th>Nama Kereta</th>
                    <th>Stasiun Asal</th>
                    <th>Stasiun Tujuan</th>
                    <th>Waktu Keberangkatan</th>
                    <th>Waktu Kedatangan</th>
                    <th>Detail Kereta</th> 
                </tr>
            </thead>
            <tbody>
            <tr>
                     <td>1</td>
                    <td>Kereta Jenggala</td>
                    <td>Stasiun Mojokerto</td>
                    <td>Stasiun Sidoarjo</td>
                    <td>06:00</td>
                    <td>06:47</td>
                    <td><a href="{{ route('tracking1-page') }}" class="train-link">Lacak Kereta</a></td>

                </tr>

                <tr>
                    <td>2</td>
                    <td>Kereta Jenggala</td>
                    <td>Stasiun Sidoarjo</td>
                    <td>Stasiun Mojokerto</td>
                    <td>07:05</td>
                    <td>07:46</td>
                    <td><a href="https://example.com/tracking/penataran-1000" class="train-link">Lacak Kereta</a></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Kereta Jenggala</td>
                    <td>Stasiun Mojokerto</td>
                    <td>Stasiun Surabaya Gubeng</td>
                    <td>08:10</td>
                    <td>09:13</td>
                    <td><a href="https://example.com/tracking/penataran-1000" class="train-link">Lacak Kereta</a></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Kereta Jenggala</td>
                    <td>Stasiun Surabaya Gubeng</td>
                    <td>Stasiun Mojokerto</td>
                    <td>16:14</td>
                    <td>17:35</td>
                    <td><a href="https://example.com/tracking/penataran-1000" class="train-link">Lacak Kereta</a></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Kereta Jenggala</td>
                    <td>Stasiun Sidoarjo</td>
                    <td>Stasiun Mojokerto</td>
                    <td>18:05</td>
                    <td>18:45</td>
                    <td><a href="https://example.com/tracking/penataran-1000" class="train-link">Lacak Kereta</a></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Kereta Jenggala</td>
                    <td>Stasiun Sidoarjo</td>
                    <td>Stasiun Mojokerto</td>
                    <td>23:48</td>
                    <td>19:29</td>
                    <td><a href="https://example.com/tracking/penataran-1000" class="train-link">Lacak Kereta</a></td>
                </tr>
                <!-- Tambahkan baris lain sesuai kebutuhan -->
            </tbody>
        </table>
    </div>
</div>

<a class="back-to-home" href="{{ route('index') }}">Kembali ke Halaman Utama</a>

<!-- Script untuk menampilkan jam -->
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

        // Mendapatkan semua elemen <td> dengan waktu keberangkatan
        var departureTimes = document.querySelectorAll('tbody tr td:nth-child(5)');
        
        // Loop melalui semua elemen <td> dan membandingkan waktu keberangkatan
        for (var i = 0; i < departureTimes.length; i++) {
            var departureTime = departureTimes[i].innerText;
            var [departureHour, departureMinute] = departureTime.split(':');
            var [currentHour, currentMinute] = [today.getHours(), today.getMinutes()];
            // Membandingkan waktu keberangkatan dengan waktu saat ini
            if (parseInt(departureHour) === currentHour && parseInt(departureMinute) <= currentMinute) {
                // Jika waktu keberangkatan sudah lewat, tambahkan kelas 'blocked-row'
                departureTimes[i].parentNode.classList.add('blocked-row');
            }
        }
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
            { name: 'Kereta Jenggala', departureTime: '06:00', arrivalTime: '06:57', from: 'Stasiun Mojokerto', to: 'Stasiun Sidorajo' },
            { name: 'Kereta Jenggala', departureTime: '07:05', arrivalTime: '07:46', from: 'Stasiun Sidoarjo', to: 'Stasiun Mojokerto' },
            { name: 'Kereta Jenggala', departureTime: '08:10', arrivalTime: '09:13', from: 'Stasiun Mojokerto', to: 'Stasiun Surabaya Gubeng' },
            { name: 'Kereta Jenggala', departureTime: '16:14', arrivalTime: '17:35', from: 'Stasiun Surabaya Gubeng', to: 'Stasiun Mojokerto' },
            { name: 'Kereta Jenggala', departureTime: '18:05', arrivalTime: '18:45', from: 'Stasiun Mojokerto', to: 'Stasiun Sidoarjo' },
            { name: 'Kereta Jenggala', departureTime: '23:48', arrivalTime: '19:29', from: 'Stasiun Sidoarjo', to: 'Stasiun Mojokerto' }
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
            trainInfo.innerHTML = `${currentTrain.name} berangkat dari ${currentTrain.from} menuju ${currentTrain.to} pada jam ${currentTrain.departureTime} dan tiba di tujuan pada jam ${currentTrain.arrivalTime}`;
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
