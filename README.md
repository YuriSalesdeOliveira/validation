# Validate

Esse projeto é um componente PHP para fazer a valição.

## Instalação

```shell
composer require yuri-oliveira/validate
```

## Como usar

### Validando

```php

<?php

use YuriOliveira\Validate\Validate;

require_once(__DIR__ . '/vendor/autoload.php');

$data = [
    'name' => 'Anthony Edward Stark Jr',
    'email' => 'TonyEsterco@hotmail.com',
    'password' => '',
];

$validate = Validate::create($data);

$validate->validate([
    'name' => ['max:250', 'required'],
    'email' => ['email', 'required'],
    'password' => ['min:8', 'max:100', 'required']
]);


print_r($validate->errors());

// Retorno de erros
// [
//     'password' => 'O campo password deve conter no mínimo 8 caracteres.'
// ];

```

### Condições para validar

Tudo o que vier depois da condição só será validado se a condição for atendida.

```php
$validate->validate([
    'email' => ['condition:filled', 'email']
    'password' => ['condition:empty', 'required']
]);

```

Criando condições personalizadas.

Obs: A condição deve sempre retornar um boolean. Se retornar true significar que as validações devem continuar, caso retorne false as validações serão interrompidas.

```php
<?php

use YuriOliveira\Validate\Condition;

require_once(__DIR__ . '/vendor/autoload.php');

Condition::extend('custom', function($value, $key) {
    return is_string($value) ? true : false;
});

```

#### Mensagens de erro

O arquivo contendo as mensagens é um array associativo onde a chave é o erro e o valor é a mensagem. Alguns erros irão precisar de filtros para tipos de dados (string, numeric, file e array). Abaixo contém uma parte do arquivo de mensagens de erro.

```php
return [
    'required' => 'O campo :attribute é obrigatório.',
    'email' => 'O campo :attribute deve conter um email válido.',
    'max' => [
        'string' => 'O campo :attribute deve conter no máximo :max caracteres.',
        'file' => 'O arquivo :attribute deve ter o tamanho máximo de :max.'
    ]
];

```
Também podemos inserir mais mensagens de erro personalizadas utilizando o método "extend" da class "Message".

```php
<?php

use YuriOliveira\Validate\Message\Message;

require_once(__DIR__ . '/vendor/autoload.php');

$customMessages = [
    'custom' => 'O campo :attribute é customizado'
];

Message::extend($customMessages);

```

Para obter as mensagens utilizamos o método "get".

Mensagens simples:

```php

Message::get('required', 'email');
// resultado: O campo email é obrigatório.
```

Mensagens que possuem tipos e um parâmetro:
```php
Message::get('max.string', 'password', parameter: 25);
// resultado: O campo password deve conter no máximo 25 caracteres.

```

### Validações personalizadas

Em caso de erro a validação deve rotornar uma mensagem (podemos obter pela classe Message e utilizar a mensagem criada no exemplo anterior) em caso de aprovação deve retornar "true".

```php

Validate::extend('custom', function($key, $value) {

    if (!is_string($value)) {

        return Message::get('custom', $key);
    }

    return true;
});

```

### Requisitos

- PHP 7.4 ou superior

