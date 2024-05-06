<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AntaresController extends Controller
{
    // Properti untuk menyimpan data kursi terbaru
    private $seatCountGerbong1;
    private $seatCountGerbong2;

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

        // Ambil data dari respons untuk gerbong 1
        $this->seatCountGerbong1 = $this->fetchSeatCount($responseGerbong1);

        // Ambil data dari respons untuk gerbong 2
        $this->seatCountGerbong2 = $this->fetchSeatCount($responseGerbong2);

        // Kirim data ke tampilan dengan variabel yang diperlukan
        return view('welcome', [
            'seatCountGerbong1' => $this->seatCountGerbong1['sisakursi'],
            'seatCountGerbong2' => $this->seatCountGerbong2['sisakursi'],
        ]);
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
        $responseGerbong1 = $client->get('/~/antares-cse/antares-id/MonitoringKeretaApi/blacknode/la');

        // Kirim permintaan untuk mendapatkan data terbaru dari Antares untuk gerbong 2
        $responseGerbong2 = $client->get('/~/antares-cse/antares-id/MonitoringKeretaApi/whitenode/la');

        // Ambil data dari respons untuk gerbong 1
        $this->seatCountGerbong1 = $this->fetchSeatCount($responseGerbong1);

        // Ambil data dari respons untuk gerbong 2
        $this->seatCountGerbong2 = $this->fetchSeatCount($responseGerbong2);

        // Kemudian, kirim data yang diperbarui sebagai respons
        return response()->json([
            'seatCountGerbong1' => $this->seatCountGerbong1,
            'seatCountGerbong2' => $this->seatCountGerbong2,
        ]);
    }

    private function fetchSeatCount($response)
    {
        $data = json_decode($response->getBody(), true);

        if(isset($data['m2m:cin']) && is_array($data['m2m:cin'])) {
            $latestData = $data['m2m:cin'];
            $seatCount = isset($latestData['con']) ? json_decode($latestData['con'], true) : ['sisakursi' => 'Data tidak tersedia'];
        } else {
            $seatCount = ['sisakursi' => 'Data tidak tersedia'];
        }
        
        return $seatCount;
    }
}
