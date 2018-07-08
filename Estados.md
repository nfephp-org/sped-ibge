# Estados

# Formas de USO

### Modificador get() --> JSON

Buscar estados, retorno em JSON (original IBGE)

```php
use NFePHP\Ibge\Ibge;

try {
    $ibge = new Ibge();
    $resp = $ibge->estados()->get();
    echo "<pre>";
    print_r($resp);
    echo "</pre>";
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

### Modificador toStd() --> STDCLASS

Buscar estados, retorno em stdClass (do original do IBGE)

```php
use NFePHP\Ibge\Ibge;

try {
    $ibge = new Ibge();
    $resp = $ibge->estados()->toStd();
    echo "<pre>";
    print_r($resp);
    echo "</pre>";
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

### Modificador toArray() --> ARRAY

Buscar estados, retorno em array (do original do IBGE)

```php
use NFePHP\Ibge\Ibge;

try {
    $ibge = new Ibge();
    $resp = $ibge->estados()->toArray();
    echo "<pre>";
    print_r($resp);
    echo "</pre>";
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

### Modificador toCSV() --> CSV

Buscar estados, retorno em CSV (somente parte dos dados são retornados)

> NOTA: o caracter separador pode ser modificado usando o parametro $separador

```php
use NFePHP\Ibge\Ibge;

try {
    $separador = ',';
    $ibge = new Ibge();
    $resp = $ibge->estados()->toCSV($separador);
    echo "<pre>";
    print_r($resp);
    echo "</pre>";
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

### Modificador toSQL() --> SQL

Buscar estados, retorno em SQL (somente parte dos dados são retornados)

> NOTA: o nome da tabela da base de dados pode ser modificada usando o parametro $tabela

```php
use NFePHP\Ibge\Ibge;

try {
    $tabela = 'estados';
    $ibge = new Ibge();
    $resp = $ibge->estados()->toSQL($tabela);
    echo "<pre>";
    print_r($resp);
    echo "</pre>";
} catch (\Exception $e) {
    echo $e->getMessage();
}
```


## Método modificador refresh()

O modificador refresh() força a atualização do dado fornecido, e deve ser usado com quando existem alterações de estados ou municipios e desejamos atualizar esses dados.
Inicialmente os estados e municipios (de todos os estados brasileiros) são mantidos em arquivos na pasta storage, e esse modificar os atualiza.

```php
use NFePHP\Ibge\Ibge;

try {
    $ibge = new Ibge();
    $resp = $ibge->estados()->refresh()->get();
    echo "<pre>";
    print_r($resp);
    echo "</pre>";
} catch (\Exception $e) {
    echo $e->getMessage();
}
```


