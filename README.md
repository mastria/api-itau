# API Itaú

[![Maintainer](http://img.shields.io/badge/maintainer-@mastria-blue.svg?style=flat-square)](https://twitter.com/mastria)
[![Source Code](http://img.shields.io/badge/source-mastria/api%E2%80%93itau-blue.svg?style=flat-square)](https://github.com/mastria/api-itau)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/mastria/api-itau.svg?style=flat-square)](https://packagist.org/packages/mastria/api-itau)
[![Latest Version](https://img.shields.io/github/release/mastria/api-itau.svg?style=flat-square)](https://github.com/mastria/api-itau/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build](https://img.shields.io/scrutinizer/build/g/mastria/api-itau.svg?style=flat-square)](https://scrutinizer-ci.com/g/mastria/api-itau)
[![Quality Score](https://img.shields.io/scrutinizer/g/mastria/api-itau.svg?style=flat-square)](https://scrutinizer-ci.com/g/mastria/api-itau)
[![Total Downloads](https://img.shields.io/packagist/dt/mastria/api-itau.svg?style=flat-square)](https://packagist.org/packages/mastria/api-itau)

###### Esta API está habilitada a utilizar a API PIX do banco central, bolecode do Itaú, alteração e baixa utilizando a API de boleto do Itaú

### APIs de Referência

[https://devportal.itau.com.br/nossas-apis/itau-ep9-gtw-pix-recebimentos-conciliacoes-v2-ext?tab=especificacaoTecnica](https://devportal.itau.com.br/nossas-apis/itau-ep9-gtw-pix-recebimentos-conciliacoes-v2-ext?tab=especificacaoTecnica)

[https://devportal.itau.com.br/nossas-apis/itau-ep9-gtw-pix-recebimentos-ext-v2?tab=especificacaoTecnica#operation/post/cob](https://devportal.itau.com.br/nossas-apis/itau-ep9-gtw-pix-recebimentos-ext-v2?tab=especificacaoTecnica#operation/post/cob)

## Installation

API Itaú é disponibilizado através do composer:

```bash
"mastria/api-itau": "^2.3"
```

or run

```bash
composer require mastria/api-itau
```

## Documentation

#### API pix:

```php
<?php

require __DIR__ . "/../vendor/autoload.php";

use Itau\API\Itau;
use Itau\API\Pix\Pix;

try{
    $itau = new Itau(
        "clientID",
        "secretToken",
        __DIR__ . "/caminhoCertificado",
        __DIR__ . "/caminhoCertificadoKey"
    );

    #Descomente este trecho caso queira imprimir na tela o JSON da requisição
    #$itau->setDebug(true);

    //pix
    $pix = new Pix();
    $pix->setChave('chavePixCadastradaBanco');
    $pix->valor()->setOriginal('10.00');
    $response = $itau->pix($pix);

    //capturando o payload do PIX (copia e cola)
    $response->getPixCopiaECola();
} catch(Exception $e){

}
```

#### API bolecode (Boleto + PIX):

```php
<?php

require __DIR__ . "/../vendor/autoload.php";

use Itau\API\Itau;
use Itau\API\BoleCode\BoleCode;

try{
    $itau = new Itau(
        "clientID",
        "secretToken",
        __DIR__ . "/caminhoCertificado",
        __DIR__ . "/caminhoCertificadoKey"
    );

    #Descomente este trecho caso queira imprimir na tela o JSON da requisição
    #$itau->setDebug(true);

    #Explicações dos campos após este exemplo
    $boleCode = new BoleCode (
        $modo, $agencia, $conta, $contaDV, $valor, $tipoBoleto, $numeroDocumento, $nome, $tipoPessoa,
        $documento, $endereco, $numero, $complemento, $bairro, $cidade, $siglaEstado, $cep, $nossoNumero,
        $vencimento, $chavePix, $tipoMulta, $percentualMulta, $tipoJuros, $percentualJuros
    );

    $response = $itau->boleCode($boleCode);

    #Caso tenha sucesso, conseguirá recuperar o TXID dessa maneira
    $response->getTxid();

    #PIXCOPIA E COLA - Em caso de sucesso
    $response->getPixCopiaECola();

} catch(Exception $e){

}
```

### Explicação dos campos

##### Modo

BoleCode::ETAPA_EFETIVO ou BoleCode::ETAPA_TESTE

##### Tipo Boleto

DadoBoleto::ESPECIE_DS = Boleto de Serviço

DadoBoleto::ESPECIE_DM = Boleto de Venda

##### Tipo Pessoa

TipoPessoa::PESSOA_FISICA = Para CPF

TipoPessoa::PESSOA_JURIDICA = Para CNPJ

##### Sigla Estado

Duas Sílabas apenas = Ex: SP

##### Nosso Número

Seu número.É de sua responsabilidade gerar esse número único para boleto.

##### Vencimento

Padrão: Y-m-d (não possui tratamento de conversão)

##### Tipo Multa

Multa::SEM_MULTA = Sem multa

Multa::PERCENTUAL = Percentual

##### Valor Multa

2 = 2%

##### Tipo Juros

Juros::SEM_JUROS = Sem juros

Juros::PERCENTUAL_MENSAL = Percentual mensal

##### Valor Juros

1 = 1% am

```php
<?php

require __DIR__ . "/../vendor/autoload.php";

use Itau\API\Itau;

try{
    $itau = new Itau(
        "clientID",
        "secretToken",
        __DIR__ . "/caminhoCertificado",
        __DIR__ . "/caminhoCertificadoKey"
    );

    #Descomente este trecho caso queira imprimir na tela o JSON da requisição
    #$itau->setDebug(true);

    $response = $itau->baixarBoleto('agencia', 'contaComDVSemTraço', 'cateira(geralmente 109)', 'nossoNumeroSemDV');
  
    if($response->getStatusCode() == 204){
        //Sucesso quando retornado o status code 204
    }
} catch(Exception $e){

}
```

#### API Alterar Valor:

**ATENÇÃO: O clientId, SecretToken e certificados devem ser diferentes do utilizado na API do PIX e Bolecode**

```php
<?php

require __DIR__ . "/../vendor/autoload.php";

use Itau\API\Itau;

try{
    $itau = new Itau(
        "clientID",
        "secretToken",
        __DIR__ . "/caminhoCertificado",
        __DIR__ . "/caminhoCertificadoKey"
    );

    #Descomente este trecho caso queira imprimir na tela o JSON da requisição
    #$itau->setDebug(true);

    $response = $itau->alterarValorBoleto(
        'agencia', 'contaComDVSemTraço', 'cateira(geralmente 109)', 'nossoNumeroSemDV',
        new Valor('100.00')
    );
  
    if($response->getStatusCode() == 204){
        //Sucesso quando retornado o status code 204
    }
} catch(Exception $e){

}
```

#### API Alterar Vencimento:

```php
<?php

require __DIR__ . "/../vendor/autoload.php";

use Itau\API\Itau;
use Itau\API\Vencimento\Vencimento;

try{
    $itau = new Itau(
        "clientID",
        "secretToken",
        __DIR__ . "/caminhoCertificado",
        __DIR__ . "/caminhoCertificadoKey"
    );

    #Descomente este trecho caso queira imprimir na tela o JSON da requisição
    #$itau->setDebug(true);

    $response = $itau->alterarVencimentoBoleto(
        'agencia', 'contaComDVSemTraço', 'cateira(geralmente 109)', 'nossoNumeroSemDV',
        new Vencimento('novoVencimento (Y-m-d)')
    );
  
    if($response->getStatusCode() == 204){
        //Sucesso quando retornado o status code 204
    }
} catch(Exception $e){

}
```

## Contribuição

Contribuições são bem-vindas!
Se você tiver sugestões de melhorias ou exemplos adicionais, crie um *pull request* ou abra uma *issue*.

## Credits

- [Leandro Ferreira Marcelli](https://github.com/leandroferreirama)

## License

The MIT License (MIT). Please see [License File](https://github.com/mastria/api-itau/blob/master/LICENSE) for more information.
