<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class WhatsAppService
{
    protected $client;
    protected $apiUrl;
    protected $diviceId;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = env('WHCENTER_API_URL');
        $this->diviceId = env('WHCENTER_DEVICE_ID');
    }

    public function sendMessage($phoneNumber, $message)
    {
        try {
            $url = 'https://app.whacenter.com/api/send';

                $ch = curl_init($url);

                $data = array(
                    'device_id' => $this->diviceId,
                    'number' => $phoneNumber,
                    'message' =>$message,
                );

                // Encode the data as JSON
                $payload = json_encode($data);

                // Set cURL options
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                // Execute cURL request
                $result = curl_exec($ch);

                // Close cURL session
                curl_close($ch);

                
                        

            return json_decode($result, true);
        } catch (RequestException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }
}
