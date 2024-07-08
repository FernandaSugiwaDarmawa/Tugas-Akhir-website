<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rute Kereta Api Jenggala</title>
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
            text-align: center;
        }
        .blocked-row {
            background-color: #ffcccc;
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
            text-decoration: none;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
            display: inline-block;
        }
        .back-to-home:hover {
            background-color: #0056b3;
        }
        .button-container {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Rute Kereta Api Jenggala</h2>
    <div class="clock" id="clock"></div>
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
                    <td>Stasiun Sidoarjo</td>
                    <td>-</td>
                    <td>07:05</td>
                    <td id="status1">-</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Stasiun Tulangan</td>
                    <td>07:16</td>
                    <td>07:18</td>
                    <td id="status2">-</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Stasiun Tarik</td>
                    <td>07:33</td>
                    <td>07:35</td>
                    <td id="status3">-</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Stasiun Mojokerto</td>
                    <td>07:46</td>
                    <td>-</td>
                    <td id="status4">-</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="button-container">
    <a class="back-to-home" href="{{ url('/jadwal-kereta') }}">Kembali ke Jadwal Kereta</a>
</div>

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

        updateStatus(h, m);
    }

    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }

    function updateStatus(currentHour, currentMinute) {
        var rows = document.querySelectorAll('tbody tr');
        rows.forEach(function(row) {
            var arrivalTime = row.querySelector('td:nth-child(3)').innerText;
            var departureTime = row.querySelector('td:nth-child(4)').innerText;

            var [arrivalHour, arrivalMinute] = arrivalTime.split(':').map(Number);
            var [departureHour, departureMinute] = departureTime.split(':').map(Number);

            if (arrivalHour === currentHour && arrivalMinute === currentMinute) {
                row.querySelector('td:nth-child(5)').innerText = 'Tiba';
            } else if (departureHour === currentHour && departureMinute === currentMinute) {
                row.querySelector('td:nth-child(5)').innerText = 'Berangkat';
            } else {
                row.querySelector('td:nth-child(5)').innerText = '-';
            }
        });
    }

    startTime();
</script>

</body>
</html>
