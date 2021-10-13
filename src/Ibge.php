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

namespace NFePHP\Ibge;

use NFePHP\Ibge\Rest;

/**
 * Class for get cities from IBGE RestAPI
 * 
 * @category  Library
 * @package   NFePHP\Ibge
 * @author    Roberto L. Machado <liuux.rlm@gmail.com>
 * @copyright 2021 NFePHP Copyright (c) 
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      http://github.com/nfephp-org/sped-ibge
 */
final class Ibge
{
    const ESTADOS = 1;
    const MUNICIPIOS = 2;
    
    /**
     * Lista com as UF
     * 
     * @var string 
     */
    public $ufs;
    /**
     * Lista de cidades da UF
     *
     * @var string 
     */
    public $cities;
    /**
     * Ultima consulta
     * 
     * @var int
     */
    protected $lastconsult;
    /**
     * Ultima UF pelo codigo
     * 
     * @var int
     */
    protected $lastcuf;
    /**
     * Ultima uf consultada
     * 
     * @var string
     */
    protected $lastuf;
    /**
     * Path para storage local
     * 
     * @var string
     */
    protected $path;
    
    /**
     * Lista de ufs
     * 
     * @var array 
     */
    protected $uflist = [
        12 => 'AC',
        27 => 'AL',
        13 => 'AM',
        91 => 'AN',
        16 => 'AP',
        29 => 'BA',
        23 => 'CE',
        53 => 'DF',
        32 => 'ES',
        52 => 'GO',
        21 => 'MA',
        31 => 'MG',
        50 => 'MS',
        51 => 'MT',
        15 => 'PA',
        25 => 'PB',
        26 => 'PE',
        22 => 'PI',
        41 => 'PR',
        33 => 'RJ',
        24 => 'RN',
        11 => 'RO',
        14 => 'RR',
        43 => 'RS',
        42 => 'SC',
        28 => 'SE',
        35 => 'SP',
        17 => 'TO',
    ];
    
    /**
     * Constructor Load flysystem and UFs from file
     * 
     * @param string|null $uf sigla ou codigo da UF
     */
    public function __construct(string $uf = null)
    {
        $this->path = __DIR__."/../storage";
        $this->ufs = file_get_contents($this->path . '/estados.json');
        $this->_loaduf($uf);
    }
    
    /**
     * Static instantiation off class
     * 
     * @param string|null $uf sigla ou codigo da UF
     * 
     * @return $this
     */
    public static function uf(string $uf = null)
    {
        return new static($uf);
    }
    
    /**
     * Carrega propriedades da classe 
     * 
     * @param string $uf sigla ou codigo da UF
     * 
     * @return void
     * 
     * @throws \Exception
     */
    private function _loaduf(string $uf = null)
    {
        if (empty($uf)) {
            return;
        }
        if ($uf == 'all') {
            $this->lastuf = $uf;
            $this->lastcuf = 0;
            return;
        }
        if (is_numeric($uf)) {
            if (empty($this->uflist[$uf])) {
                throw new \Exception("Esse código não existe.");
            }
            $this->lastuf = $this->uflist[$uf];
            $this->lastcuf = (int) $uf;
        } else {
            $uf = strtoupper($uf);
            $codelist = array_flip($this->uflist);
            if (empty($codelist[$uf])) {
                throw new \Exception("Esse código não existe.");
            }
            $this->lastcuf = (int) $codelist[$uf];
            $this->lastuf = $uf;
        }
    }

    /**
     * Returns this class setting for states
     * 
     * @return $this
     */
    public function estados()
    {
        $this->lastconsult = self::ESTADOS;
        return $this;
    }
    
    /**
     * Returns this class setting for cities from giving state
     *
     * @param string $uf sigla ou codigo da UF
     * 
     * @return $this
     */
    public function cidades(string $uf = null)
    {
        if (!empty($uf)) {
            $this->_loaduf($uf);
        }
        if ($this->lastuf === 'all') {
            return $this->all();
        }
        if (empty($this->lastuf)) {
            return $this;    
        }
        $this->lastconsult = self::MUNICIPIOS;
        $path = $this->path . '/municipios_'.$this->lastcuf.'.json';
        if (!is_file($path)) {
            $this->refresh();
        }
        $this->cities = file_get_contents($path);
        return $this;
    }
    
    /**
     * Get all brasilian cities
     * 
     * @return $this
     */
    protected function all()
    {
        $this->lastconsult = self::MUNICIPIOS;
        $acities = [];
        $ufs = json_decode($this->ufs);
        foreach ($ufs as $u) {
            $cUF = $u->id;
            $this->lastuf = $u->sigla;
            $this->lastcuf = $cUF;
            $path = $this->path . '/municipios_'.$cUF.'.json';
            if (!is_file($path)) {
                $this->refresh();
            }
            $cities = file_get_contents($path);
            $arr = json_decode($cities, true);
            foreach ($arr as $r) {
                array_push($acities, $r);
            }
        }
        $this->cities = json_encode($acities);
        return $this;
    }
    
    /**
     * Returns data in original json format, like received from IBGE
     *
     * @return string
     */
    public function get()
    {
        if ($this->lastconsult == self::ESTADOS) {
            return $this->ufs;
        } else {
            if (empty($this->cities)) {
                throw new \Exception(
                    "Para obter a lista de cidades "
                    . "deve ser indicar uma UF"
                );
            }
            return $this->cities;
        }
    }
    
    /**
     * Force reload data from IBGE into filesystem file
     * 
     * @return $this
     */
    public function refresh()
    {
        if ($this->lastconsult == self::ESTADOS) {
            $url = "https://servicodados.ibge.gov.br/api/v1/localidades//estados";
            $this->ufs = Rest::send($url);
            file_put_contents($this->path . '/estados.json', $this->ufs);
        } else {
            if ($this->lastuf === 'all') {
                $ufs = json_decode($this->ufs);
                foreach ($ufs as $u) {
                    $cUF = $u->id;
                    $url = "https://servicodados.ibge.gov.br/api/v1"
                        . "/localidades/estados/$cUF/municipios";
                    $this->cities = Rest::send($url);
                    $name = '/municipios_' . $cUF . '.json';
                    file_put_contents($this->path . $name, $this->cities);
                }
            } else {
                $url = "https://servicodados.ibge.gov.br/api/v1/localidades"
                    . "/estados/$this->lastcuf/municipios";
                $this->cities = Rest::send($url);
                $name = '/municipios_'.$this->lastcuf.'.json';
                file_put_contents($this->path . $name, $this->cities);
            }
        }
        return $this;
    }
    
    /**
     * Returns data in stdClass format
     *
     * @return \stdClass
     */
    public function toStd()
    {
        return json_decode($this->get());
    }
    
    /**
     * Retruns data in array format
     *
     * @return array
     */
    public function toArray()
    {
        return json_decode($this->get(), true);
    }
    
    /**
     * Return data as CSV format
     *
     * @param string $separador separador dos campos
     * 
     * @return string
     */
    public function toCSV($separador = ',')
    {
        $csv = "";
        if ($this->lastconsult == self::ESTADOS) {
            $csv = "ID,SIGLA,NOME,REGIAO_ID,REGIAO_SIGLA,REGIAO_NOME\n";
            $ufs = json_decode($this->ufs);
            foreach ($ufs as $u) {
                $nome = str_replace("'", ' ', $u->nome);
                $reg = $u->regiao;
                $csv .= "{$u->id},"
                    . "{$u->sigla},"
                    . "{$nome},"
                    . "{$reg->id},"
                    . "{$reg->sigla},"
                    . "{$reg->nome}\n";
            }
        } else {
            if (!empty($this->cities)) {
                $cities = json_decode($this->cities);
                $csv = "ID,NOME,UF\n";
                foreach ($cities as $c) {
                    $nome = str_replace("'", ' ', $c->nome);
                    $uf = $c->microrregiao->mesorregiao->UF->sigla;
                    $csv .= "{$c->id},{$nome},{$uf}\n";
                }
            }
        }
        $csv = str_replace(',', $separador, $csv);
        return $csv;
    }
    
    /**
     * Return data as SQL format
     *
     * @param string $tablename nome da tabela
     * 
     * @return string
     */
    public function toSQL($tablename = '')
    {
        $sql = '';
        if ($this->lastconsult == self::ESTADOS) {
            $name = empty($tablename) ? 'estados' : $tablename;
            $ufs = json_decode($this->ufs);
            foreach ($ufs as $u) {
                $reg = $u->regiao;
                $nome = str_replace("'", ' ', $u->nome);
                $sql .= "INSERT INTO $name ("
                    . "id, sigla, nome, regiao_id, regiao_sigla, regiao_nome"
                    . ") VALUES (";
                $sql .= "{$u->id},"
                    . "'{$u->sigla}',"
                    . "'{$nome}',"
                    . "'{$reg->id}',"
                    . "'{$reg->sigla}',"
                    . "'{$reg->nome}');\n";
            }
        } else {
            $name = $name = empty($tablename) ? 'municipios' : $tablename;
            if (!empty($this->cities)) {
                $cities = json_decode($this->cities);
                foreach ($cities as $c) {
                    $uf = $c->microrregiao->mesorregiao->UF->sigla;
                    $nome = str_replace("'",  ' ', $c->nome);
                    $sql .= "INSERT INTO $name (id, nome, uf) VALUES (";
                    $sql .= "{$c->id},'{$nome}', '{$uf}');\n";
                }
            }
        }
        return $sql;
    }
}
