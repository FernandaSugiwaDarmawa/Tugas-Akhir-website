<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Ketersediaan Kursi KA Jenggala</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
            padding: 10px;
            box-sizing: border-box;
        }
        .box {
            width: 48%;
            height: 150px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            text-align: center;
            padding-top: 20px;
            margin-top: 20px;
            display: inline-block;
            position: relative;
            box-sizing: border-box;
        }
        .title {
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 10px;
            color: black;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 10px 0;
            z-index: 1;
            background-color: inherit;
        }
        .box:nth-child(1) .title {
            background-color: #ffd700;
        }
        .box:nth-child(2) .title {
            background-color: #ffc0cb;
        }
        .box:nth-child(3) .title {
            background-color: #87CEEB;
        }
        .box:nth-child(4) .title {
            background-color: #FFA07A;
        }
        .seat-count {
            font-size: 50px;
            font-weight: bold;
            color: black;
            position: absolute;
            bottom: 10px;
            left: 0;
            width: 100%;
            z-index: 1;
        }
        img {
            width: 100%;
            max-width: 400px;
            display: block;
            margin: 0 auto;
        }
        h2, h3 {
            font-size: 30px;
            margin-top: 20px;
            margin-bottom: 10px;
            color: black;
        }
        #jadwal-button {
            background-color: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
        }
        #jadwal-button:active {
            background-color: darkblue;
        }
        @media (max-width: 600px) {
            .container {
                padding: 5px;
            }
            .box {
                width: 100%;
                margin-top: 10px;
                height: 120px;
            }
            .title {
                font-size: 20px;
            }
            .seat-count {
                font-size: 40px;
            }
            h2, h3 {
                font-size: 24px;
            }
            #jadwal-button {
                font-size: 14px;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <img src="images/kai.png" alt="KAI Logo">
</div>

<div class="container">
    <button id="jadwal-button" type="button" onclick="window.location.href='{{ route('jadwal-kereta') }}'">Lihat Jadwal Kereta</button>
</div>

<div class="container">
    <h2>Website Ketersediaan Kursi KA Jenggala</h2>
    <h3>Rute Mojokerto-Surabaya PP</h3>
</div>

<div class="container">
    <div class="box">
        <div class="title" style="background-color: #ffd700;">Gerbong 1</div>
        <div class="seat-count" id="cekpenumpang1">0</div>
    </div>
    <div class="box">
        <div class="title" style="background-color: #ffc0cb;">Gerbong 2</div>
        <div class="seat-count" id="cekpenumpang2">0</div>
    </div>
</div>

<div class="container">
    <h3>Mojokerto-Sidoarjo PP</h3>
</div>

<div class="container">
    <div class="box">
        <div class="title" style="background-color: #87CEEB;">Gerbong 3</div>
        <div class="seat-count" id="cekpenumpang3">0</div>
    </div>
    <div class="box">
        <div class="title" style="background-color: #FFA07A;">Gerbong 4</div>
        <div class="seat-count" id="cekpenumpang4">0</div>
    </div>
</div>

<div style="position: fixed; bottom: 30px; right: 10px;">
    <a href="https://wa.me/6285706418126">
        <img src="images/Whatsapp.png" alt="WhatsApp" style="width: 50px;">
    </a>
    <p style="font-size: 16px;">Hubungi Kami</p>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    var fetchDataUrl = "{{ route('fetch-data') }}";

    function updateData() {
        $.ajax({
            url: fetchDataUrl,
            method: "GET",
            success: function(response) {
                $('#cekpenumpang1').text(response.seatCountGerbong1.sisakursi);
                $('#cekpenumpang2').text(response.seatCountGerbong2.sisakursi);
                $('#cekpenumpang3').text(response.seatCountGerbong3.sisakursi);
                $('#cekpenumpang4').text(response.seatCountGerbong4.sisakursi);
            }
        });
    }

    updateData();

    setInterval(updateData, 1000);
</script>

</body>
</html>
