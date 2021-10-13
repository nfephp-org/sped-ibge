# sped-ibge

Esta classe usa a API do IBGE para buscar os estados e seus códigos e as cidades desses estados e seus codigos.
Para uso dos projetos SPED da Receita Federal e das SEFAZ.

[![Actions Status][ico-workflow]][link-actions]

[![Latest Stable Version][ico-stable]][link-packagist]
[![License][ico-license]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

[![Issues][ico-issues]][link-issues]
[![Forks][ico-forks]][link-forks]
[![Stars][ico-stars]][link-stars]

O intuito desse projeto é prover uma fonte de dados para serem usados na manutenção das bases de dados dos aplicativos que emitem documentos para o projetos SPED.

> NOTA: Esse serviço do IBGE não deve ser acessado diretamente a cada consulta de seu cliente, pois será mais lento e instável que buscar isso na sua própria base de dados.

Esta classe possui 2 métodos principais e vários modificadores.

# Métodos principais

## [function estados()](Estados.md)

## [function cidades($uf)](Municipios.md)

> *IMPORTANTE: a pasta "storage" deve ter permissões de escrita pelo usuário que executa o PHP.*

## Install

**Este pacote está listado no [Packgist](https://packagist.org/) foi desenvolvido para uso do [Composer](https://getcomposer.org/), portanto não será explicitada nenhuma alternativa de instalação.**

*E deve ser instalado com:*
```bash
composer require nfephp-org/sped-ibge
```
Ou ainda alterando o composer.json do seu aplicativo inserindo:
```json
"require": {
    "nfephp-org/sped-ibge" : "^1.0"
}
```

*Para utilizar o pacote em desenvolvimento (branch master) deve ser instalado com:*
```bash
composer require nfephp-org/sped-ibge:dev-master
```

*Ou ainda alterando o composer.json do seu aplicativo inserindo:*
```json
"require": {
    "nfephp-org/sped-ibge" : "dev-master"
}
```

> NOTA: Ao utilizar este pacote na versão em desenvolvimento não se esqueça de alterar o composer.json da sua aplicação para aceitar pacotes em desenvolvimento, alterando a propriedade "minimum-stability" de "stable" para "dev".
> ```json
> "minimum-stability": "dev"
> ```

## Requirements

Para que este pacote possa funcionar são necessários os seguintes requisitos do PHP e outros pacotes dos quais esse depende.

- PHP PHP 7.x (recomendável PHP 7.2) 
- ext-curl
- ext-json
- [league/flysystem](https://packagist.org/packages/league/flysystem)




[ico-stable]: https://poser.pugx.org/nfephp-org/sped-ibge/v/version?style=flat
[ico-downloads]: https://poser.pugx.org/nfephp-org/sped-ibge/downloads?style=flat
[ico-license]: https://poser.pugx.org/nfephp-org/nfephp/license.svg?style=flat-square
[ico-stars]: https://img.shields.io/github/stars/nfephp-org/sped-ibge.svg
[ico-forks]: https://img.shields.io/github/forks/nfephp-org/sped-ibge.svg
[ico-issues]: https://img.shields.io/github/issues/nfephp-org/sped-ibge.svg
[ico-workflow]: https://github.com/nfephp-org/sped-ibge/actions/workflows/ci.yml/badge.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/nfephp-org/sped-ibge.svg


[link-packagist]: https://packagist.org/packages/nfephp-org/sped-ibge
[link-actions]: https://github.com/nfephp-org/sped-gtin/actions
[link-downloads]: https://packagist.org/packages/nfephp-org/sped-ibge
[link-author]: https://github.com/nfephp-org
[link-issues]: https://github.com/nfephp-org/sped-ibge/issues
[link-forks]: https://github.com/nfephp-org/sped-ibge/network
[link-stars]: https://github.com/nfephp-org/sped-ibge/stargazers






  

