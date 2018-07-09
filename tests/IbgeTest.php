<?php

namespace NFePHP\Ibge\Tests;

use NFePHP\Ibge\Ibge;
use PHPUnit\Framework\TestCase;

class IbgeTest extends TestCase
{
    public $ibge;
    
    public function setUp()
    {
        $this->ibge = new Ibge();
    }
    
    public function testShouldInstantiate()
    {
        $this->assertInstanceOf(Ibge::class, $this->ibge);
    }
    
    
    public function testEstadosGet()
    {
        $expected = file_get_contents(__DIR__.'/fixtures/estados.json');
        $resp = $this->ibge->estados()->get();
        $this->assertEquals($expected, $resp);
    }
    
    public function testCidadesGetBycUF()
    {
        $expected = file_get_contents(__DIR__.'/fixtures/municipios_16.json');
        $resp = $this->ibge->cidades('16')->get();
        $this->assertEquals($expected, $resp);
    }
    
   
    public function testCidadesGetByUF()
    {
        $expected = file_get_contents(__DIR__.'/fixtures/municipios_16.json');
        $resp = $this->ibge->cidades('AP')->get();
        $this->assertEquals($expected, $resp);
    }
    
    public function testCidadesToSQLByUF()
    {
        $expected = file_get_contents(__DIR__.'/fixtures/municipios_16.sql');
        $resp = $this->ibge->cidades('AP')->toSQL();
        $this->assertEquals($expected, $resp);
    }
    
    public function testCidadesToCSVByUF()
    {
        $expected = file_get_contents(__DIR__.'/fixtures/municipios_16.csv');
        $resp = $this->ibge->cidades('AP')->toCSV();
        $this->assertEquals($expected, $resp);
    }    
    
    
}
