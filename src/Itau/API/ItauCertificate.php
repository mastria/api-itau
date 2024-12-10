<?php

namespace Itau\API;

use Exception;
use Itau\API\Exception\ItauException;

/**
 * Class ItauCertificate
 *
 * @package Itau\API
 */
class ItauCertificate
{
    private string $endpoint = 'https://sts.itau.com.br/seguranca/v1/certificado/solicitacao';

    public function criarCertificado(string $token, string $certificadoCSR)
    {
        return $this->executeRequest($token, $certificadoCSR);
    }

    public function renovarCertificado(Itau $credentials, string $certificadoCSR)
    {
        if (!$credentials->getAuthorizationToken()) {
            new Request($credentials);
        }
        $token = $credentials->getAuthorizationToken();

        return $this->executeRequest($token, $certificadoCSR);
    }

    private function executeRequest(string $token, string $certificadoCSR)
    {
        $headers = [
            'Content-Type: text/plain',
            'Authorization: Bearer ' . $token
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->endpoint,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $certificadoCSR,
        ]);

        try {
            $response = curl_exec($curl);
        } catch (Exception $e) {
            curl_close($curl);
            throw new ItauException($e->getMessage(), 100);
        }

        if ($response === false) {
            $error = curl_error($curl);
            curl_close($curl);
            throw new ItauException('CURL Error: ' . $error, 100);
        }

        $statusCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Verifica status HTTP
        if ($statusCode >= 400) {
            $obj = json_decode($response);
            $acao = $obj->acao ?? '';
            $mensagem = $obj->mensagem ?? 'Erro desconhecido';
            $acaoText = $acao ? "- {$acao}" : '';
            throw new ItauException("HTTP Error: $statusCode - $mensagem {$acaoText}", $statusCode);
        }

        // Lógica para 204
        if ($statusCode === 204) {
            return [
                'status_code' => 204
            ];
        }

        // Verifica resposta vazia
        if (empty($response)) {
            throw new ItauException('Empty response received from server.', $statusCode);
        }

        return $response;
    }
}
