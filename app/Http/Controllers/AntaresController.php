<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AntaresController extends Controller
{

    // Properti untuk menyimpan data kursi terbaru
    private $seatCountGerbong1;
    private $seatCountGerbong2;
    private $seatCountGerbong3;
    // private $seatCountGerbong4;

    public function index()
    {
        // Konfigurasi koneksi ke Antares
        $client = new Client([
            'base_uri' => 'https://platform.antares.id:8443',
            'headers' => [
                'X-M2M-Origin' => 'ed816e597656887d:f3657c657c911031', // Sesuaikan dengan access key Anda
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);

        // Kirim permintaan untuk mendapatkan data terbaru dari Antares untuk gerbong 1
        $responseGerbong1 = $client->get('/~/antares-cse/antares-id/MonitoringKeretaApi/whitenode/la');

        // Kirim permintaan untuk mendapatkan data terbaru dari Antares untuk gerbong 2
        $responseGerbong2 = $client->get('/~/antares-cse/antares-id/MonitoringKeretaApi/blacknode/la');
        
        // Kirim permintaan untuk mendapatkan data terbaru dari Antares untuk gerbong 3
        $responseGerbong3 = $client->get('/~/antares-cse/antares-id/MonitoringKeretaApi/coba/la');

        // Kirim permintaan untuk mendapatkan data terbaru dari Antares untuk gerbong 4
        // $responseGerbong4 = $client->get('/~/antares-cse/antares-id/MonitoringKeretaApi/coba1/la');

        // Ambil data dari respons untuk gerbong 1
        $this->seatCountGerbong1 = $this->fetchSeatCount($responseGerbong1);

        // Ambil data dari respons untuk gerbong 2
        $this->seatCountGerbong2 = $this->fetchSeatCount($responseGerbong2);
        
        // Ambil data dari respons untuk gerbong 3
        $this->seatCountGerbong3 = $this->fetchSeatCount($responseGerbong3);

        // Ambil data dari respons untuk gerbong 4
        // $this->seatCountGerbong4 = $this->fetchSeatCount($responseGerbong4);
        
        // Kirim data ke tampilan dengan variabel yang diperlukan
        return view('welcome', [
            'seatCountGerbong1' => $this->seatCountGerbong1,
            'seatCountGerbong2' => $this->seatCountGerbong2,
            'seatCountGerbong3' => $this->seatCountGerbong3,
        ]);
        // dd($this->seatCountGerbong1, $this->seatCountGerbong2, $this->seatCountGerbong3);
    }

    public function fetchData()
    {
        // Konfigurasi koneksi ke Antares
        $client = new Client([
            'base_uri' => 'https://platform.antares.id:8443',
            'headers' => [
                'X-M2M-Origin' => 'ed816e597656887d:f3657c657c911031', // Sesuaikan dengan access key Anda
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);

        // Kirim permintaan untuk mendapatkan data terbaru dari Antares untuk gerbong 1
        $responseGerbong1 = $client->get('/~/antares-cse/antares-id/MonitoringKeretaApi/whitenode/la');

        // Kirim permintaan untuk mendapatkan data terbaru dari Antares untuk gerbong 2
        $responseGerbong2 = $client->get('/~/antares-cse/antares-id/MonitoringKeretaApi/blacknode/la');
        
        // Kirim permintaan untuk mendapatkan data terbaru dari Antares untuk gerbong 3
        $responseGerbong3 = $client->get('/~/antares-cse/antares-id/MonitoringKeretaApi/coba/la');

        // Kirim permintaan untuk mendapatkan data terbaru dari Antares untuk gerbong 4
        // $responseGerbong4 = $client->get('/~/antares-cse/antares-id/MonitoringKeretaApi/coba1/la');

        // Ambil data dari respons untuk gerbong 1
        $this->seatCountGerbong1 = $this->fetchSeatCount($responseGerbong1);

        // Ambil data dari respons untuk gerbong 2
        $this->seatCountGerbong2 = $this->fetchSeatCount($responseGerbong2);
        
        // Ambil data dari respons untuk gerbong 3
        $this->seatCountGerbong3 = $this->fetchSeatCount($responseGerbong3);

        // Ambil data dari respons untuk gerbong 4
        // $this->seatCountGerbong4 = $this->fetchSeatCount($responseGerbong4);

        // Kemudian, kirim data yang diperbarui sebagai respons
        return response()->json([
            'seatCountGerbong1' => $this->seatCountGerbong1,
            'seatCountGerbong2' => $this->seatCountGerbong2,
            'seatCountGerbong3' => $this->seatCountGerbong3,
        ]);
    }

    private function fetchSeatCount($response) {
    $data = json_decode($response->getBody(), true);

    // Cek apakah struktur data sesuai dengan yang diharapkan
    if(isset($data['m2m:cin']) && is_array($data['m2m:cin'])) {
        $latestData = $data['m2m:cin'];
        
        // Ambil data sisa kursi
        $content = isset($latestData['con']) ? json_decode($latestData['con'], true) : null;
        
        if ($content) {
            $seatCount = isset($content['sisakursi']) ? $content['sisakursi'] : 'Data tidak tersedia';
            $recommendation = isset($content['rekomendasi']) ? $content['rekomendasi'] : 'Rekomendasi tidak tersedia';
        } else {
            $seatCount = 'Data tidak tersedia';
            $recommendation = 'Rekomendasi tidak tersedia';
        }
    } else {
        // Jika data tidak sesuai dengan yang diharapkan
        $seatCount = 'Data tidak tersedia';
        $recommendation = 'Rekomendasi tidak tersedia';
    }

    // Gabungkan data sisa kursi dan rekomendasi ke dalam array hasil
    $result = [
        'seatCount' => $seatCount,
        'recommendation' => $recommendation
    ];

    return $result;
    }

}

