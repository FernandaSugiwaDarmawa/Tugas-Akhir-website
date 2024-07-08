<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class AntaresController extends Controller
{
    // Properties to store the latest seat count data for each coach
    private $seatCountGerbong1;
    private $seatCountGerbong2;
    private $seatCountGerbong3;
    private $seatCountGerbong4;

    public function index()
    {
        try {
            // Configure the connection to Antares
            $client = new Client([
                'base_uri' => 'https://platform.antares.id:8443',
                'headers' => [
                    'X-M2M-Origin' => 'ed816e597656887d:f3657c657c911031', // Replace with your access key
                    'Content-Type' => 'application/json;ty=4',
                    'Accept' => 'application/json',
                ],
            ]);

            // Log request initiation
            Log::info('Fetching data from Antares for all coaches.');

            // Send requests to fetch the latest data from Antares for each coach
            $responseGerbong1 = $client->get('/~/antares-cse/antares-id/MonitoringKeretaApi/whitenode/la');
            Log::info('Response for Gerbong 1: ' . $responseGerbong1->getBody());
            $responseGerbong2 = $client->get('/~/antares-cse/antares-id/MonitoringKeretaApi/blacknode/la');
            Log::info('Response for Gerbong 2: ' . $responseGerbong2->getBody());
            $responseGerbong3 = $client->get('/~/antares-cse/antares-id/MonitoringKeretaApi/greynode/la');
            Log::info('Response for Gerbong 3: ' . $responseGerbong3->getBody());
            $responseGerbong4 = $client->get('/~/antares-cse/antares-id/MonitoringKeretaApi/bluenode/la');
            Log::info('Response for Gerbong 4: ' . $responseGerbong4->getBody());

            // Fetch data from responses for each coach
            $this->seatCountGerbong1 = $this->fetchSeatCount($responseGerbong1);
            $this->seatCountGerbong2 = $this->fetchSeatCount($responseGerbong2);
            $this->seatCountGerbong3 = $this->fetchSeatCount($responseGerbong3);
            $this->seatCountGerbong4 = $this->fetchSeatCount($responseGerbong4);

            // Check if data was successfully fetched before passing to the view
            if (empty($this->seatCountGerbong1) || empty($this->seatCountGerbong2) || 
                empty($this->seatCountGerbong3) || empty($this->seatCountGerbong4)) {
                throw new \Exception('Failed to fetch data from Antares');
            }

            // Pass data to the view
            return view('welcome', [
                'seatCountGerbong1' => $this->seatCountGerbong1['sisakursi'],
                'seatCountGerbong2' => $this->seatCountGerbong2['sisakursi'],
                'seatCountGerbong3' => $this->seatCountGerbong3['sisakursi'],
                'seatCountGerbong4' => $this->seatCountGerbong4['sisakursi'],
            ]);

        } catch (RequestException $e) {
            $response = $e->getResponse();
            if ($response && $response->getStatusCode() == 404) {
                Log::error('Resource not found: ' . $e->getMessage());
                return response()->json(['error' => 'Resource not found on Antares'], 404);
            }
            Log::error('RequestException fetching data from Antares: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch data from Antares: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            Log::error('Error fetching data from Antares: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch data from Antares: ' . $e->getMessage()], 500);
        }
    }

    public function fetchData()
    {
        try {
            // Configure the connection to Antares
            $client = new Client([
                'base_uri' => 'https://platform.antares.id:8443',
                'headers' => [
                    'X-M2M-Origin' => 'ed816e597656887d:f3657c657c911031', // Replace with your access key
                    'Content-Type' => 'application/json;ty=4',
                    'Accept' => 'application/json',
                ],
            ]);

            // Log request initiation
            Log::info('Fetching data from Antares for all coaches.');

            // Send requests to fetch the latest data from Antares for each coach
            $responseGerbong1 = $client->get('/~/antares-cse/antares-id/MonitoringKeretaApi/whitenode/la');
            Log::info('Response for Gerbong 1: ' . $responseGerbong1->getBody());
            $responseGerbong2 = $client->get('/~/antares-cse/antares-id/MonitoringKeretaApi/blacknode/la');
            Log::info('Response for Gerbong 2: ' . $responseGerbong2->getBody());
            $responseGerbong3 = $client->get('/~/antares-cse/antares-id/MonitoringKeretaApi/greynode/la');
            Log::info('Response for Gerbong 3: ' . $responseGerbong3->getBody());
            $responseGerbong4 = $client->get('/~/antares-cse/antares-id/MonitoringKeretaApi/bluenode/la');
            Log::info('Response for Gerbong 4: ' . $responseGerbong4->getBody());

            // Fetch data from responses for each coach
            $this->seatCountGerbong1 = $this->fetchSeatCount($responseGerbong1);
            $this->seatCountGerbong2 = $this->fetchSeatCount($responseGerbong2);
            $this->seatCountGerbong3 = $this->fetchSeatCount($responseGerbong3);
            $this->seatCountGerbong4 = $this->fetchSeatCount($responseGerbong4);

            // Check if data was successfully fetched before sending JSON response
            if (empty($this->seatCountGerbong1) || empty($this->seatCountGerbong2) || 
                empty($this->seatCountGerbong3) || empty($this->seatCountGerbong4)) {
                throw new \Exception('Failed to fetch data from Antares');
            }

            // Return updated data as JSON response
            return response()->json([
                'seatCountGerbong1' => $this->seatCountGerbong1,
                'seatCountGerbong2' => $this->seatCountGerbong2,
                'seatCountGerbong3' => $this->seatCountGerbong3,
                'seatCountGerbong4' => $this->seatCountGerbong4,
            ]);

        } catch (RequestException $e) {
            $response = $e->getResponse();
            if ($response && $response->getStatusCode() == 404) {
                Log::error('Resource not found: ' . $e->getMessage());
                return response()->json(['error' => 'Resource not found on Antares'], 404);
            }
            Log::error('RequestException fetching data from Antares: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch data from Antares: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            Log::error('Error fetching data from Antares: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch data from Antares: ' . $e->getMessage()], 500);
        }
    }

    private function fetchSeatCount($response)
    {
        $data = json_decode($response->getBody(), true);
        Log::info('Response data: ' . json_encode($data));

        if (isset($data['m2m:cin']) && is_array($data['m2m:cin'])) {
            $latestData = $data['m2m:cin'];
            $seatCount = isset($latestData['con']) ? json_decode($latestData['con'], true) : ['sisakursi' => 'Data not available'];
        } else {
            $seatCount = ['sisakursi' => 'Data not available'];
        }

        Log::info('Fetched seat count: ' . json_encode($seatCount));
        return $seatCount;
    }
}
