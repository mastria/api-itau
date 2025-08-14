<?php
namespace Itau\API;

/**
 * Class TokenCache
 * 
 * Gerencia o cache do token de autenticação da API do Itaú
 * 
 * @package Itau\API
 */
class TokenCache
{
    /**
     * Tempo de vida padrão do token em segundos (5 minutos)
     */
    private const DEFAULT_TOKEN_LIFETIME = 300; // 5 minutos

    /**
     * Nome do arquivo de cache padrão
     */
    private const DEFAULT_CACHE_FILENAME = 'itau_api_token_cache.json';

    /**
     * Caminho do arquivo de cache
     *
     * @var string
     */
    private string $cacheFilePath;

    /**
     * Tempo de vida do token em segundos
     *
     * @var int
     */
    private int $tokenLifetime;

    /**
     * TokenCache constructor.
     *
     * @param string|null $cachePath Caminho customizado para o arquivo de cache (opcional)
     * @param int $tokenLifetime Tempo de vida do token em segundos (padrão: 300s/5min)
     */
    public function __construct(?string $cachePath = null, int $tokenLifetime = self::DEFAULT_TOKEN_LIFETIME)
    {
        $this->tokenLifetime = $tokenLifetime;
        $this->cacheFilePath = $this->resolveCachePath($cachePath);
    }

    /**
     * Resolve o caminho do arquivo de cache
     *
     * @param string|null $cachePath
     * @return string
     */
    private function resolveCachePath(?string $cachePath): string
    {
        if ($cachePath !== null) {
            if (is_dir($cachePath)) {
                return rtrim($cachePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . self::DEFAULT_CACHE_FILENAME;
            } else {
                return $cachePath;
            }
        }
        
        $tempDir = sys_get_temp_dir();
        return $tempDir . DIRECTORY_SEPARATOR . self::DEFAULT_CACHE_FILENAME;
    }

    /**
     * Salva o token no cache
     *
     * @param string $token Token de autenticação
     * @param string $clientId Client ID usado para gerar o token
     * @return bool True se salvou com sucesso
     */
    public function saveToken(string $token, string $clientId): bool
    {
        $cacheData = [
            'token' => $token,
            'client_id' => $clientId,
            'created_at' => time(),
            'expires_at' => time() + $this->tokenLifetime
        ];

        $jsonData = json_encode($cacheData, JSON_PRETTY_PRINT);
        
        $directory = dirname($this->cacheFilePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        return file_put_contents($this->cacheFilePath, $jsonData) !== false;
    }

    /**
     * Recupera um token válido do cache
     *
     * @param string $clientId Client ID para verificar se o token é do mesmo cliente
     * @return string|null Token válido ou null se não existe/expirou
     */
    public function getValidToken(string $clientId): ?string
    {
        if (!file_exists($this->cacheFilePath)) {
            return null;
        }

        $cacheContent = file_get_contents($this->cacheFilePath);
        if ($cacheContent === false) {
            return null;
        }

        $cacheData = json_decode($cacheContent, true);
        if ($cacheData === null) {
            return null;
        }

        // Verificar se é o mesmo client_id
        if (!isset($cacheData['client_id']) || $cacheData['client_id'] !== $clientId) {
            return null;
        }

        // Verificar se o token ainda é válido
        if (!isset($cacheData['expires_at']) || time() >= $cacheData['expires_at']) {
            // Token expirado, limpar cache
            $this->clearCache();
            return null;
        }

        return $cacheData['token'] ?? null;
    }

    /**
     * Verifica se existe um token válido no cache
     *
     * @param string $clientId Client ID para verificar
     * @return bool True se existe token válido
     */
    public function hasValidToken(string $clientId): bool
    {
        return $this->getValidToken($clientId) !== null;
    }

    /**
     * Limpa o cache removendo o arquivo
     *
     * @return bool True se removeu com sucesso
     */
    public function clearCache(): bool
    {
        if (file_exists($this->cacheFilePath)) {
            return unlink($this->cacheFilePath);
        }
        return true;
    }

    /**
     * Obtém informações sobre o cache atual
     *
     * @return array|null Informações do cache ou null se não existe
     */
    public function getCacheInfo(): ?array
    {
        if (!file_exists($this->cacheFilePath)) {
            return null;
        }

        $cacheContent = file_get_contents($this->cacheFilePath);
        if ($cacheContent === false) {
            return null;
        }

        $cacheData = json_decode($cacheContent, true);
        if ($cacheData === null) {
            return null;
        }

        $timeLeft = max(0, ($cacheData['expires_at'] ?? 0) - time());
        
        return [
            'client_id' => $cacheData['client_id'] ?? null,
            'created_at' => $cacheData['created_at'] ?? null,
            'expires_at' => $cacheData['expires_at'] ?? null,
            'time_left_seconds' => $timeLeft,
            'is_valid' => $timeLeft > 0,
            'cache_file_path' => $this->cacheFilePath
        ];
    }

    /**
     * Define um novo tempo de vida para tokens futuros
     *
     * @param int $seconds Tempo em segundos
     * @return self
     */
    public function setTokenLifetime(int $seconds): self
    {
        $this->tokenLifetime = $seconds;
        return $this;
    }

    /**
     * Obtém o tempo de vida atual configurado
     *
     * @return int Tempo em segundos
     */
    public function getTokenLifetime(): int
    {
        return $this->tokenLifetime;
    }

    /**
     * Obtém o caminho do arquivo de cache
     *
     * @return string
     */
    public function getCacheFilePath(): string
    {
        return $this->cacheFilePath;
    }
}
