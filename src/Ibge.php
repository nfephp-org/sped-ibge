<?php

namespace NFePHP\Ibge;

use NFePHP\Ibge\Rest;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

class Ibge
{
    const ESTADOS = 1;
    const MUNICIPIOS = 2;
    
    public $ufs;
    public $cities;
    protected $lastconsult;
    protected $lastcuf;
    protected $lastuf;
    protected $filesystem;
    
    /**
     * Constructor
     * Load flysystem and UFs from file
     */
    public function __construct()
    {
        $adapter = new Local(__DIR__ . '/../storage/');
        $this->filesystem = new Filesystem($adapter);
        $this->ufs = $this->filesystem->read('estados.json');
    }

    /**
     * Returns this class setting for states 
     * @return $this
     */
    public function estados()
    {
        $this->lastconsult = self::ESTADOS;
        return $this;
    }
    
    /**
     * Returns this class setting for cities from giving state
     * @param string $uf
     * @return $this
     */
    public function cidades($uf)
    {
        if ($uf === 'all') {
            $this->lastuf = $uf;
            return $this->all();
        }
        $cUF = '';
        $ufs = json_decode($this->ufs);
        if (!is_numeric($uf)) {
            $this->uf = $uf;
            foreach ($ufs as $u) {
                if ($u->sigla == $uf) {
                    $cUF = $u->id;
                    break;
                }
            }
        } else {
            $cUF = $uf;
            foreach ($ufs as $u) {
                if ($u->id == $cUF) {
                    $this->uf = $u->sigla;
                    break;
                }
            }
        }
        if (empty($cUF)) {
            throw new \Exception("Esse estado [$uf] não existe!");
        }
        $this->lastconsult = self::MUNICIPIOS;
        $this->lastcuf = $cUF;
        $path = 'municipios_'.$cUF.'.json';
        if (!$this->filesystem->has($path)) {
            $this->refresh();
        }
        $this->cities = $this->filesystem->read($path);
        return $this;
    }
    
    /**
     * Get all brasilian cities
     * @return $this
     */
    public function all()
    {
        $this->lastconsult = self::MUNICIPIOS;
        $acities = [];
        $ufs = json_decode($this->ufs);
        foreach ($ufs as $u) {
            $cUF = $u->id;
            $this->lastuf = $u->sigla;
            $this->lastcuf = $cUF;
            $path = 'municipios_'.$cUF.'.json';
            if (!$this->filesystem->has($path)) {
                $this->refresh();
            }
            $cities = $this->filesystem->read($path);
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
     * @return string
     */
    public function get()
    {
        if ($this->lastconsult == self::ESTADOS) {
            return $this->ufs;
        } else {
            return $this->cities;
        }
    }
    
    /**
     * Force reload data from IBGE into filesystem file
     */
    public function refresh()
    {
        if ($this->lastconsult == self::ESTADOS) {
            $url = "https://servicodados.ibge.gov.br/api/v1/localidades//estados";
            $this->ufs = Rest::send($url);
            $this->filesystem->put('estados.json', $this->ufs);
        } else {
            if ($this->lastuf === 'all') {
                $ufs = json_decode($this->ufs);
                foreach ($ufs as $u) {
                    $cUF = $u->id;
                    $url = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/$cUF/municipios";
                    $this->cities = Rest::send($url);
                    $this->filesystem->put('municipios_'.$cUF.'.json', $this->cities);
                }
            } else {
                $url = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/$this->lastcuf/municipios";
                $this->cities = Rest::send($url);
                $this->filesystem->put('municipios_'.$this->lastcuf.'.json', $this->cities);
            }
        }
        return $this;
    }
    
    /**
     * Returns data in stdClass format
     * @return \stdClass
     */
    public function toStd()
    {
        return json_decode($this->get());
    }
    
    /**
     * Retruns data in array format
     * @return array
     */
    public function toArray()
    {
        return json_decode($this->get(), true);
    }
    
    /**
     * Return data as CSV format
     * @param string $separador
     * @return string
     */
    public function toCSV($separador = ',')
    {
        $csv = "";
        if ($this->lastconsult == self::ESTADOS) {
            $csv = "ID,SIGLA,NOME,REGIAO_ID,REGIAO_SIGLA,REGIAO_NOME\n";
            $ufs = json_decode($this->ufs);
            foreach ($ufs as $u) {
                $reg = $u->regiao;
                $csv .= "$u->id,$u->sigla,$u->nome,$reg->id,$reg->sigla,$reg->nome\n";
            }
        } else {
            if (!empty($this->cities)) {
                $cities = json_decode($this->cities);
                $csv = "ID,NOME,UF\n";
                foreach ($cities as $c) {
                    $uf = $c->microrregiao->mesorregiao->UF->sigla;
                    $csv .= "$c->id,$c->nome,$uf\n";
                }
            }
        }
        $csv = str_replace(',', $separador, $csv);
        return $csv;
    }
    
    /**
     * Return data as SQL format
     * @param string $tablename
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
                $sql .= "INSERT INTO $name (id, sigla, nome, regiao_id, regiao_sigla, regiao_nome) VALUES (";
                $sql .= "$u->id,'$u->sigla','$u->nome','$reg->id', '$reg->sigla', '$reg->nome');\n";
            }
        } else {
            $name = $name = empty($tablename) ? 'municipios' : $tablename;
            if (!empty($this->cities)) {
                $cities = json_decode($this->cities);
                foreach ($cities as $c) {
                    $uf = $c->microrregiao->mesorregiao->UF->sigla;
                    $sql .= "INSERT INTO $name (id, nome, uf) VALUES (";
                    $sql .= "$c->id,'$c->nome', '$uf');\n";
                }
            }
        }
        return $sql;
    }
}
