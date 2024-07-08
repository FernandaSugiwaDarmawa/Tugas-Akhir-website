<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kereta Api</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            text-align: center;
            max-width: 100%;
            position: relative;
            padding: 10px;
            box-sizing: border-box;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            overflow: auto;
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
        .blocked-row {
            background-color: #ffcccc;
        }
        td:nth-child(5),
        td:nth-child(6),
        td:nth-child(7) {
            text-align: center;
        }
        .blinking-text {
            animation: blink-animation 1s steps(5, start) infinite;
        }
        @keyframes blink-animation {
            to {
                visibility: hidden;
            }
        }
        .full-width-table {
            width: 100%;
            max-width: none;
            margin-left: auto;
            margin-right: auto;
        }
        .back-to-home {
            position: fixed;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-to-home:hover {
            background-color: #0056b3;
        }
        .train-link {
            text-decoration: underline;
            color: blue;
            cursor: pointer;
        }
        @media (max-width: 600px) {
            .clock {
                font-size: 18px;
            }
            th, td {
                padding: 6px;
                font-size: 14px;
            }
            .back-to-home {
                font-size: 14px;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Jadwal Kereta Api</h2>
    <div class="clock" id="clock"></div>
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
                    <td><a href="{{ route('tracking2-page') }}" class="train-link">Lacak Kereta</a></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Kereta Jenggala</td>
                    <td>Stasiun Mojokerto</td>
                    <td>Stasiun Surabaya Kota</td>
                    <td>08:10</td>
                    <td>09:25</td>
                    <td><a href="{{ route('tracking3-page') }}" class="train-link">Lacak Kereta</a></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Kereta Jenggala</td>
                    <td>Stasiun Surabaya Kota</td>
                    <td>Stasiun Mojokerto</td>
                    <td>16:00</td>
                    <td>17:35</td>
                    <td><a href="{{ route('tracking4-page') }}" class="train-link">Lacak Kereta</a></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Kereta Jenggala</td>
                    <td>Stasiun Mojokerto</td>
                    <td>Stasiun Sidoarjo</td>
                    <td>18:05</td>
                    <td>18:45</td>
                    <td><a href="{{ route('tracking5-page') }}" class="train-link">Lacak Kereta</a></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Kereta Jenggala</td>
                    <td>Stasiun Sidoarjo</td>
                    <td>Stasiun Mojokerto</td>
                    <td>18:50</td>
                    <td>19:29</td>
                    <td><a href="{{ route('tracking6-page') }}" class="train-link">Lacak Kereta</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<a class="back-to-home" href="{{ route('index') }}">Kembali ke Halaman Utama</a>

<script>
    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('clock').innerHTML = h + ":" + m + ":" + s;
        setTimeout(startTime, 1000);

        var departureTimes = document.querySelectorAll('tbody tr td:nth-child(5)');
        
        for (var i = 0; i < departureTimes.length; i++) {
            var departureTime = departureTimes[i].innerText;
            var [departureHour, departureMinute] = departureTime.split(':');
            var [currentHour, currentMinute] = [today.getHours(), today.getMinutes()];

            if (parseInt(departureHour) === currentHour && parseInt(departureMinute) <= currentMinute) {
                departureTimes[i].parentNode.classList.add('blocked-row');
            }
        }
    }

    function checkTime(i) {
        if (i < 10) {i = "0" + i};
        return i;
    }
    startTime();

    function updateTrainInfo() {
        var today = new Date();
        var currentHour = today.getHours();
        var currentMinute = today.getMinutes();
        var trainInfo = document.getElementById('trainInfo');
        var trainSchedule = [
            { name: 'Kereta Jenggala', departureTime: '06:00', arrivalTime: '06:57', from: 'Stasiun Mojokerto', to: 'Stasiun Sidorajo' },
            { name: 'Kereta Jenggala', departureTime: '07:05', arrivalTime: '07:46', from: 'Stasiun Sidoarjo', to: 'Stasiun Mojokerto' },
            { name: 'Kereta Jenggala', departureTime: '08:10', arrivalTime: '09:25', from: 'Stasiun Mojokerto', to: 'Stasiun Surabaya Kota' },
            { name: 'Kereta Jenggala', departureTime: '16:00', arrivalTime: '17:35', from: 'Stasiun Surabaya Kota', to: 'Stasiun Mojokerto' },
            { name: 'Kereta Jenggala', departureTime: '18:05', arrivalTime: '18:45', from: 'Stasiun Mojokerto', to: 'Stasiun Sidoarjo' },
            { name: 'Kereta Jenggala', departureTime: '18:50', arrivalTime: '19:29', from: 'Stasiun Sidoarjo', to: 'Stasiun Mojokerto' }
        ];

        var currentTrain = null;
        for (var i = 0; i < trainSchedule.length; i++) {
            var train = trainSchedule[i];
            var [departureHour, departureMinute] = train.departureTime.split(':');
            if (parseInt(departureHour) === currentHour && parseInt(departureMinute) <= currentMinute) {
                currentTrain = train;
                break;
            }
        }

        if (currentTrain) {
            trainInfo.innerHTML = `${currentTrain.name} berangkat dari ${currentTrain.from} menuju ${currentTrain.to} pada jam ${currentTrain.departureTime} dan tiba di tujuan pada jam ${currentTrain.arrivalTime}`;
            trainInfo.classList.add('blinking-text');
        } else {
            trainInfo.innerHTML = '';
            trainInfo.classList.remove('blinking-text');
        }
    }
    setInterval(updateTrainInfo, 1000);
</script>

</body>
</html>
