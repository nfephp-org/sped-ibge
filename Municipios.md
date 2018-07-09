# Municipios

# Formas de USO

### Modificador get() --> JSON

Buscar municipios, retorno em JSON (original IBGE)

> NOTA: o estado pode ser alterado usando o parametro $uf, e esse parametro também pode ser indicado pelo seu código cUF (ex. 35)

```php
use NFePHP\Ibge\Ibge;

try {
    $uf = 'SP';
    $ibge = new Ibge();
    $resp = $ibge->municipios($uf)->get();
    echo "<pre>";
    print_r($resp);
    echo "</pre>";
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

### Modificador toStd() --> STDCLASS

Buscar municipios, retorno em stdClass (do original do IBGE)

```php
use NFePHP\Ibge\Ibge;

try {
    $uf = 35;
    $ibge = new Ibge();
    $resp = $ibge->municipios($uf)->toStd();
    echo "<pre>";
    print_r($resp);
    echo "</pre>";
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

### Modificador toArray() --> ARRAY

Buscar municipios, retorno em array (do original do IBGE)

```php
use NFePHP\Ibge\Ibge;

try {
    $uf = 'AM';
    $ibge = new Ibge();
    $resp = $ibge->municipios($uf)->toArray();
    echo "<pre>";
    print_r($resp);
    echo "</pre>";
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

### Modificador toCSV() --> CSV

Buscar municipios, retorno em CSV (somente parte dos dados são retornados)

> NOTA: o caracter separador pode ser modificado usando o parametro $separador

```php
use NFePHP\Ibge\Ibge;

try {
    $uf = 'RJ';
    $separador = '|';
    $ibge = new Ibge();
    $resp = $ibge->municipios($uf)->toCSV($separador);
    echo "<pre>";
    print_r($resp);
    echo "</pre>";
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

### Modificador toSQL() --> SQL

Buscar municipios, retorno em SQL (somente parte dos dados são retornados)

> NOTA: o nome da tabela da base de dados pode ser modificada usando o parametro $tabela

> NOTA: a opção de estado 'all' irá trazer todos os municipios de todos os estados.

```php
use NFePHP\Ibge\Ibge;

try {
    $uf = 'all';
    $tabela = 'estados';
    $ibge = new Ibge();
    $resp = $ibge->municipios($uf)->toSQL($tabela);
    echo "<pre>";
    print_r($resp);
    echo "</pre>";
} catch (\Exception $e) {
    echo $e->getMessage();
}
```


## Método modificador refresh()

O modificador refresh() força a atualização do dado fornecido, e deve ser usado com quando existem alterações de estados ou municipios e desejamos atualizar esses dados.
Inicialmente os estados e municipios (de todos os estados brasileiros) são mantidos em arquivos na pasta storage, e esse modificador os atualiza.

```php
use NFePHP\Ibge\Ibge;

try {
    $ibge = new Ibge();
    $resp = $ibge->municipios('all')->refresh()->get();
    echo "<pre>";
    print_r($resp);
    echo "</pre>";
} catch (\Exception $e) {
    echo $e->getMessage();
}
```
