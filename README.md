# sped-ibge

Esta classe usa a API do IBGE para buscar os estados e seus códigos e as cidades desses estados e seus codigos.
Para uso dos projetos SPED da Receita Federal e das SEFAZ.

[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]

[![Latest Stable Version][ico-stable]][link-packagist]
[![Latest Version on Packagist][ico-version]][link-packagist]
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

## [function municipios($uf)](Municipios.md)


[ico-stable]: https://poser.pugx.org/nfephp-org/sped-ibge/version
[ico-stars]: https://img.shields.io/github/stars/nfephp-org/sped-ibge.svg?style=flat-square
[ico-forks]: https://img.shields.io/github/forks/nfephp-org/sped-ibge.svg?style=flat-square
[ico-issues]: https://img.shields.io/github/issues/nfephp-org/sped-ibge.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/nfephp-org/sped-ibge/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/nfephp-org/sped-ibge.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/nfephp-org/sped-ibge.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/nfephp-org/sped-ibge.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/nfephp-org/sped-ibge.svg?style=flat-square
[ico-license]: https://poser.pugx.org/nfephp-org/nfephp/license.svg?style=flat-square


[link-packagist]: https://packagist.org/packages/nfephp-org/sped-ibge
[link-travis]: https://travis-ci.org/nfephp-org/sped-ibge
[link-scrutinizer]: https://scrutinizer-ci.com/g/nfephp-org/sped-ibge/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/nfephp-org/sped-ibge
[link-downloads]: https://packagist.org/packages/nfephp-org/sped-ibge
[link-author]: https://github.com/nfephp-org
[link-issues]: https://github.com/nfephp-org/sped-ibge/issues
[link-forks]: https://github.com/nfephp-org/sped-ibge/network
[link-stars]: https://github.com/nfephp-org/sped-ibge/stargazers






  

