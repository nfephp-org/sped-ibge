<?php

/**
 * This file belongs to the NFePHP project
 * php version 7.0 or higher
 *
 * @category  Library
 * @package   NFePHP\Ibge
 * @author    Roberto L. Machado <liuux.rlm@gmail.com>
 * @copyright 2021 NFePHP Copyright (c) 
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      http://github.com/nfephp-org/sped-ibge
 */

namespace NFePHP\Ibge\Tests;

use NFePHP\Ibge\Ibge;
use PHPUnit\Framework\TestCase;

/**
 * Unit Test Class
 *
 * @category  Library
 * @package   NFePHP\Ibge
 * @author    Roberto L. Machado <liuux.rlm@gmail.com>
 * @copyright 2021 NFePHP Copyright (c) 
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      http://github.com/nfephp-org/sped-ibge
 */
class IbgeTest extends TestCase
{
    /**
     * Classe
     * 
     * @var \NFePHP\Ibge\Ibge
     */
    public $ibge;
    
    /**
     * Can instantiate class test 
     * 
     * @covers Ibge
     * @covers ::__contruct
     * 
     * @return void
     */
    public function testCanInstantiate()
    {
        $ibge = new Ibge();
        $this->assertInstanceOf('NFePHP\Ibge\Ibge', $ibge);
    }
    
    /**
     * Can instantiate static class test 
     * 
     * @covers Ibge
     * @covers ::__contruct
     * @covers ::uf
     * 
     * @return void
     */
    public function testCanInstantiateStatic()
    {
        $ibge = Ibge::uf();
        $this->assertInstanceOf('NFePHP\Ibge\Ibge', $ibge);
    }

    
    /**
     * Test Get estados
     * 
     * @covers Ibge
     * @covers ::estados
     * @covers ::get
     * 
     * @return void
     */
    public function testEstadosGet()
    {
        $expected = file_get_contents(__DIR__.'/fixtures/estados.json');
        $resp = Ibge::uf()->estados()->get();
        $this->assertEquals($expected, $resp);
    }
    
    /**
     * Test Get cidades pelo codigo da UF
     * 
     * @covers Ibge
     * @covers ::_loaduf
     * @covers ::cidades
     * @covers ::get
     * 
     * @return void
     */
    public function testCidadesGetBycUF()
    {
        $expected = file_get_contents(__DIR__.'/fixtures/municipios_16.json');
        $resp = Ibge::uf()->cidades('16')->get();
        $this->assertEquals($expected, $resp);
    }
    
    /**
     * Test Get cidades pela sigla da UF
     * 
     * @covers Ibge
     * @covers ::_loaduf
     * @covers ::cidades
     * @covers ::get
     * 
     * @return void
     */
    public function testCidadesGetByUF()
    {
        $expected = file_get_contents(__DIR__.'/fixtures/municipios_16.json');
        $resp = Ibge::uf('AP')->cidades()->get();
        $this->assertEquals($expected, $resp);
    }
    
    /**
     * Test toCSV cidades pelo codigo da UF
     * 
     * @covers Ibge
     * @covers ::_loaduf
     * @covers ::cidades
     * @covers ::get
     * @covers ::toCSV
     * 
     * @return void
     */
    public function testCidadesToStdByUF()
    {
        $expected = json_decode(
            file_get_contents(__DIR__.'/fixtures/municipios_16.json')
        );
        $resp = Ibge::uf()->cidades('AP')->toStd();
        $this->assertEquals($expected, $resp);
    }  
    
    /**
     * Test toSQL cidades pelo codigo da UF
     * 
     * @covers Ibge
     * @covers ::_loaduf
     * @covers ::cidades
     * @covers ::get
     * @covers ::toSQL
     * 
     * @return void
     */
    public function testCidadesToSQLByUF()
    {
        $expected = file_get_contents(__DIR__.'/fixtures/municipios_16.sql');
        $resp = Ibge::uf()->cidades('AP')->toSQL();
        $this->assertEquals($expected, $resp);
    }
    
    /**
     * Test toCSV cidades pelo codigo da UF
     * 
     * @covers Ibge
     * @covers ::_loaduf
     * @covers ::cidades
     * @covers ::get
     * @covers ::toCSV
     * 
     * @return void
     */
    public function testCidadesToCSVByUF()
    {
        $expected = file_get_contents(__DIR__.'/fixtures/municipios_16.csv');
        $resp = Ibge::uf()->cidades('AP')->toCSV();
        $this->assertEquals($expected, $resp);
    }    
    
    
}
