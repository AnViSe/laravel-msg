<?php

if (! function_exists('sendMessage')) {
    function sendMessage(string $message, string $to)
    {
        $postData = [
            'to' => $to,
            'text' => $message
        ];
        $postDataJson = json_encode($postData);
        $authorization = base64_encode(env('INFOBIP_USERNAME') . ":" . env('INFOBIP_PASSWORD'));

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('INFOBIP_BASE_URL') . "/sms/2/text/single",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postDataJson,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic " . $authorization,
                "Content-Type: application/json",
                "Accept: application/json"
            ),
        ));
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($httpCode == 200) {
            $result = json_decode($response);;
        } else {
            $result = null;
        }
        return $result;
    }
}
