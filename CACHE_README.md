# Cache de Token - API Itaú

Esta biblioteca agora inclui um sistema de cache automático para tokens de autenticação, evitando autenticações desnecessárias e melhorando a performance.

## Funcionalidades

- **Cache automático**: O token é automaticamente salvo e reutilizado enquanto válido
- **Expiração inteligente**: Tokens são renovados automaticamente após 5 minutos (configurável)
- **Flexibilidade**: Pode usar cache padrão (arquivo temporário) ou diretório personalizado
- **Thread-safe**: Cada cliente (client_id) tem seu próprio cache
- **Limpeza automática**: Tokens expirados são removidos automaticamente

## Configurações de Cache

### 1. Cache Padrão (Recomendado)

```php
use Itau\API\Itau;

$itau = new Itau($clientId, $clientSecret, $certificate, $certificateKey);

// Habilitar cache com configurações padrão
// - Arquivo: {temp_dir}/itau_api_token_cache.json
// - Validade: 300 segundos (5 minutos)
$itau->enableTokenCache();
```

### 2. Cache em Diretório Personalizado

```php
// Cache em diretório específico do projeto
$itau->enableTokenCache('./cache/');

// Ou caminho absoluto
$itau->enableTokenCache('/var/app/cache/');
```

### 3. Cache com Tempo Personalizado

```php
// Cache com validade de 10 minutos (600 segundos)
$itau->enableTokenCache(null, 600);

// Cache personalizado com diretório e tempo
$itau->enableTokenCache('./cache/', 480); // 8 minutos
```

### 4. Arquivo Específico para Cache

```php
// Definir arquivo específico
$itau->enableTokenCache('./config/meu_token.json');
```

## Uso Básico

```php
<?php
require_once 'vendor/autoload.php';

use Itau\API\Itau;
use Itau\API\Environment;

// Configurar API
$itau = new Itau($clientId, $clientSecret, $certificate, $certificateKey);

// Habilitar cache
$itau->enableTokenCache();

// Primeira chamada - fará autenticação e salvará no cache
$response1 = $itau->pix($pixData);

// Segunda chamada - usará token do cache (mais rápida)
$response2 = $itau->pix($pixData2);

// O token será renovado automaticamente após 5 minutos
```

## Gerenciamento do Cache

### Verificar Status do Cache

```php
// Verificar se cache está habilitado
if ($itau->isTokenCacheEnabled()) {
    echo "Cache habilitado!";
}

// Obter informações do cache
$cache = $itau->getTokenCache();
$info = $cache->getCacheInfo();

if ($info) {
    echo "Token válido: " . ($info['is_valid'] ? 'Sim' : 'Não') . "\n";
    echo "Tempo restante: " . $info['time_left_seconds'] . " segundos\n";
    echo "Arquivo de cache: " . $info['cache_file_path'] . "\n";
}
```

### Verificar Token Válido

```php
$cache = $itau->getTokenCache();

// Verificar se existe token válido
if ($cache->hasValidToken($clientId)) {
    echo "Token válido encontrado!";
} else {
    echo "Necessário renovar token.";
}
```

### Limpar Cache Manualmente

```php
// Limpar cache específico
$itau->clearTokenCache();

// Ou diretamente na instância de cache
$cache = $itau->getTokenCache();
$cache->clearCache();
```

### Desabilitar Cache

```php
// Desabilitar cache temporariamente
$itau->disableTokenCache();

// Habilitar novamente
$itau->enableTokenCache();
```

## Configurações Avançadas

### Alterar Tempo de Vida Durante Execução

```php
$cache = $itau->getTokenCache();

// Definir novo tempo de vida (afeta apenas tokens futuros)
$cache->setTokenLifetime(900); // 15 minutos

// Verificar tempo atual
$tempoAtual = $cache->getTokenLifetime();
```

### Múltiplos Clientes

```php
// Cada client_id tem seu próprio cache
$itau1 = new Itau($clientId1, $clientSecret1, $cert1, $key1);
$itau1->enableTokenCache('./cache/cliente1/');

$itau2 = new Itau($clientId2, $clientSecret2, $cert2, $key2);
$itau2->enableTokenCache('./cache/cliente2/');

// Os caches são independentes
```

## Localizações Padrão do Cache

### Windows

```
C:\Users\{usuario}\AppData\Local\Temp\itau_api_token_cache.json
```

### Linux/macOS

```
/tmp/itau_api_token_cache.json
```

## Estrutura do Arquivo de Cache

```json
{
    "token": "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9...",
    "client_id": "seu_client_id",
    "created_at": 1692012345,
    "expires_at": 1692012645
}
```

## Considerações de Segurança

1. **Permissões**: Arquivos de cache são criados com permissão 0644
2. **Limpeza**: Tokens expirados são removidos automaticamente
3. **Client ID**: Cada cache é vinculado a um client_id específico
4. **Diretórios**: Diretórios de cache são criados automaticamente se não existirem

## Tratamento de Erros

O sistema de cache é tolerante a falhas:

- Se o cache falhar, a autenticação normal será realizada
- Erros de escrita no cache não afetam as operações da API
- Arquivos corrompidos são ignorados e recriados automaticamente

## Exemplo Completo

```php
<?php
require_once 'vendor/autoload.php';

use Itau\API\Itau;
use Itau\API\Environment;
use Itau\API\Pix\Pix;
use Itau\API\Pix\Valor;

try {
    // Configurar API
    $itau = new Itau($clientId, $clientSecret, $certificate, $certificateKey);
  
    // Habilitar cache em diretório do projeto
    $itau->enableTokenCache('./cache/', 600); // 10 minutos
  
    // Verificar status do cache
    if ($itau->isTokenCacheEnabled()) {
        $info = $itau->getTokenCache()->getCacheInfo();
  
        if ($info && $info['is_valid']) {
            echo "Usando token em cache (expira em " . $info['time_left_seconds'] . "s)\n";
        } else {
            echo "Gerando novo token...\n";
        }
    }
  
    // Realizar operações normalmente
    $pix = new Pix();
    $pix->setChave('chavePixCadastradaBanco');
    $pix->valor()->setOriginal('10.00');
    $response = $itau->pix($pix);
  
    echo "PIX criado com sucesso!\n";
    echo $response->getPixCopiaECola();
  
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
```

## Logs e Debug

Para debug, você pode monitorar o arquivo de cache:

```bash
# Linux/macOS
tail -f /tmp/itau_api_token_cache.json

# Windows PowerShell
Get-Content -Path "$env:TEMP\itau_api_token_cache.json" -Wait
```
