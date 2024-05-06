<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Ketersediaan Kursi KA Jenggala</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; /* Warna latar belakang */
            margin: 0;
            padding: 0;
        }
        .container {
            text-align: center;
            max-width: 800px; /* Menetapkan lebar maksimum untuk kontainer */
            margin: 0 auto; /* Pusatkan kontainer */
            position: relative; /* Tambahkan posisi relatif untuk kontainer */
        }
        .box {
            width: 48%; /* Lebar div gerbong */
            height: 150px;
            background-color: #f0f0f0; /* Warna latar belakang */
            border: 1px solid #ccc; /* Garis tepi */
            text-align: center;
            padding-top: 20px;
            margin-top: 20px; /* Berikan jarak antar box */
            display: inline-block; /* Agar box berada dalam satu baris */
            position: relative; /* Tambahkan posisi relatif */
        }
        .title {
            font-size: 35px;
            font-weight: bold;
            margin-bottom: 10px;
            color: black; /* Warna teks */
            position: absolute; /* Tetapkan posisi absolut */
            top: 0; /* Geser ke atas */
            left: 0; /* Geser ke kiri */
            width: 100%; /* Lebar 100% untuk memenuhi card */
            padding: 10px 0; /* Padding atas dan bawah */
            z-index: 1; /* Tetapkan indeks z agar tulisan berada di depan */
            background-color: inherit; /* Hapus latar belakang khusus */
        }
        .box:nth-child(1) .title {
            background-color: #ffd700; /* Warna latar belakang untuk Gerbong 1 */
        }
        .box:nth-child(2) .title {
            background-color: #ffc0cb; /* Warna latar belakang untuk Gerbong 2 */
            
        }
        .box:nth-child(3) .title {
            background-color: #87CEEB; /* Warna latar belakang untuk Gerbong 3 */
        }
        .box:nth-child(4) .title {
            background-color: #FFA07A; /* Warna latar belakang untuk Gerbong 4 */
        }
        .seat-count {
            font-size: 60px;
            font-weight: bold;
            color: black; /* Warna angka */
            position: absolute; /* Tetapkan posisi absolut */
            bottom: 10px; /* Geser ke bawah */
            left: 0; /* Geser ke kiri */
            width: 100%; /* Lebar 100% untuk memenuhi card */
            z-index: 1; /* Tetapkan indeks z agar angka berada di depan */
        }
        img {
            width: 400px;
            display: block;
            margin: 0 auto;
        }
        h2 {
            font-size: 40px;
            margin-top: 20px; /* Berikan jarak atas dari gambar */
            margin-bottom: 10px; /* Tambahkan jarak bawah */
            color: black; /* Warna teks */
        }
        #jadwal-button:active {
    background-color: blue;
}

        
    </style>
</head>
<body>

<!-- Image at the top -->
<div class="container">
    <img src="images/kai.png" style="width: 200px;">
</div>

<!-- Tulisan "Website Ketersediaan Kursi KA Jenggala" dan "Rute Mojokerto-Surabaya PP" -->
<div class="container">
    <h2>Website Ketersediaan Kursi KA Jenggala</h2>
    <h3>Rute Mojokerto-Surabaya PP</h3>
</div>

<!-- Tambahkan tag <a> di bawah tulisan "Mojokerto-Surabaya PP" -->
<button id="jadwal-button" type="button" onclick="window.location.href='{{ route('jadwal-kereta') }}'">Lihat Jadwal Kereta</button>





<div class="container">
    <!-- menampilkan gerbong 1 -->
    <div class="box">
        <div class="title" style="background-color: #ffd700;">Gerbong 1</div>
        <div class="seat-count" id="cekpenumpang1">0</div>
    </div>

    <!-- menampilkan gerbong 2 -->
    <div class="box">
        <div class="title" style="background-color: #ffc0cb;">Gerbong 2</div>
        <div class="seat-count" id="cekpenumpang2">0</div>
    </div>

    <!-- menampilkan tulisan Mojokerto-Sidoarjo PP -->
    <div class="container">
        <h3 style="margin-top: 20px;">Mojokerto-Sidoarjo PP</h3>
    </div>

    <!-- menampilkan gerbong 3 -->
    <div class="box">
        <div class="title" style="background-color: #87CEEB;">Gerbong 1</div>
        <div class="seat-count" id="cekpenumpang3">0</div>
    </div>

    <!-- menampilkan gerbong 4 -->
    <div class="box">
        <div class="title" style="background-color: #FFA07A;">Gerbong 2</div>
        <div class="seat-count" id="cekpenumpang4">0</div>
    </div>
</div>


<!-- Logo WhatsApp di pojok kanan bawah -->
<div style="position: fixed; bottom: 30px; right: 10px;">
    <a href="https://wa.me/6285706418126">
        <img src="images/Whatsapp.png" alt="WhatsApp" style="width: 50px;">
    </a>
    <p style="font-size: 16px;">Hubungi Kami</p>
</div>

<!-- Script AJAX untuk memperbarui data secara real-time -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    // Fungsi untuk memperbarui data secara real-time
    function updateData() {
        $.ajax({
            url: "{{ route('fetch-data') }}", // Sesuaikan dengan rute Anda
            method: "GET",
            success: function(response) {
                // Perbarui tampilan dengan data yang diperbarui dari respons
                $('#cekpenumpang1').text(response.seatCountGerbong1.sisakursi);
                $('#cekpenumpang2').text(response.seatCountGerbong2.sisakursi);
                $('#cekpenumpang3').text(response.seatCountGerbong3.sisakursi);
                $('#cekpenumpang4').text(response.seatCountGerbong4.sisakursi);
            }
        });
    }

    // Panggil fungsi updateData untuk pertama kali
    updateData();

    // Panggil fungsi updateData setiap detik
    setInterval(updateData, 1000); // Set interval ke 1000 milidetik (1 detik)
</script>

</body>
</html>
