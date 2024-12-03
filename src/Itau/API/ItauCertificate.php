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
        $endpoint = 'https://sts.itau.com.br/seguranca/v1/certificado/solicitacao';
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

        $statusCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Verifica status HTTP
        if ($statusCode >= 400) {
            throw new Exception("HTTP Error: $statusCode - $response", $statusCode);
        }

        // Lógica para 204
        if ($statusCode === 204) {
            return [
                'status_code' => 204
            ];
        }

        // Verifica resposta vazia
        if (empty($response)) {
            throw new Exception('Empty response received from server.', $statusCode);
        }

        return $response;
    }
}
