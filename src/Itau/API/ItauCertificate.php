<?php

namespace Itau\API;

use Exception;

/**
 * Class Itau
 *
 * @package Itau\API
 */
class ItauCertificate
{
    public function requestCertificate(string $token, string $certificadoCSR)
    {
        $endpoint = 'sts.itau.com.br/seguranca/v1/certificado/solicitacao';
        $headers = [
            'Content-Type: text/plain',
            'Authorization: Bearer ' . $token
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $certificadoCSR,
        ]);

        $response = curl_exec($curl);

        if ($response === false) {
            $error = curl_error($curl);
            curl_close($curl);
            throw new Exception('CURL Error: ' . $error, 100);
        }

        // Verify error
        if ($response === false) {
            $errorMessage = curl_error($curl);
        }

        $statusCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        if ($statusCode >= 400) {
            // TODO see what it means code 100
            throw new Exception($response, 100);
        }
        // Status code 204 don't have content. That means $response will be always false
        // Provides a custom content for $response to avoid error in the next if logic
        if ($statusCode === 204) {
            return [
                'status_code' => 204
            ];
        }

        if (! $response) {
            throw new Exception("Empty response, curl_error: $errorMessage", $statusCode);
        }
        return $response;
    }
}
