# API itaú

[![Maintainer](http://img.shields.io/badge/maintainer-@leandroferreirama-blue.svg?style=flat-square)](https://twitter.com/leandroferreirama)
[![Source Code](http://img.shields.io/badge/source-leandroferreirama/api-itau-blue.svg?style=flat-square)](https://github.com/leandroferreirama/api-itau)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/leandroferreirama/api-itau.svg?style=flat-square)](https://packagist.org/packages/leandroferreirama/api-itau)
[![Latest Version](https://img.shields.io/github/release/leandroferreirama/api-itau.svg?style=flat-square)](https://github.com/leandroferreirama/api-itau/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build](https://img.shields.io/scrutinizer/build/g/leandroferreirama/api-itau.svg?style=flat-square)](https://scrutinizer-ci.com/g/leandroferreirama/api-itau)
[![Quality Score](https://img.shields.io/scrutinizer/g/leandroferreirama/api-itau.svg?style=flat-square)](https://scrutinizer-ci.com/g/leandroferreirama/api-itau)
[![Total Downloads](https://img.shields.io/packagist/dt/leandroferreirama/api-itau.svg?style=flat-square)](https://packagist.org/packages/leandroferreirama/api-itau)

###### Esta api está habilitada a utilizar a API PIX do banco central, bolecode do Itaú, alteração e baixa utilizando a API de boleto do Itaú

### IMPORTANTE

- Para utilizar todas as funções da API é necessário realizar duas habilitações junto ao itaú. Uma servirá para consunir a api pix e bolecode, a outra para consumir a alteração e baixa de boleto.

## Installation

Uploader is available via Composer:

```bash
"leandroferreirama/api-itau": "^1.0"
```

or run

```bash
composer require leandroferreirama/api-itau
```

## Documentation

#### API pix:

```php
<?php

require __DIR__ . "/../vendor/autoload.php";

use Itau\API\Itau;
use Itau\API\Pix\Pix;

$itau = new Itau(
    "clientID",
    "secretToken",
    "caminhoCertificado",
    "caminhoCertificadoKey"
);

//pix
$pix = new Pix();
$pix->setChave('chavePixCadastradaBanco');
$pix->valor()->setOriginal('10.00');
$response = $itau->pix($pix);

//capturando o payload do PIX (copia e cola)
$response->getPixCopiaECola();
```

## Support

###### Se você descobrir algum problema relacionado à segurança, envie um e-mail para suporte@integracaosistema.com.br em vez de usar o rastreador de problemas.

## Credits

- [Leandro Ferreira Marcelli](https://github.com/leandroferreirama) (Developer)

## License

The MIT License (MIT). Please see [License File](https://github.com/leandroferreirama/api-itau/blob/master/LICENSE) for more information.