# Validate

Esse projeto é um componente PHP para fazer a valição

## Instalação

```shell
composer require yuri-oliveira/validate
```

## Como usar

### Validando

```php

<?php

use YuriOliveira\Validation\Message\Message;
use YuriOliveira\Validation\Validate;

require_once(__DIR__ . '/vendor/autoload.php');

$data = [
    'name' => 'Anthony Edward Stark Jr',
    'email' => 'TonyEsterco@hotmail.com',
    'password' => 'PepperPotts',
];

$validate = new Validate($data);

$validate->validate([
    'name' => ['max:250', 'required'],
    'email' => ['email', 'required'],
    'password' => ['min:8', 'max:100', 'required']
]);


print_r($validate->errors());

// Possivel retorno de erros resultantes da validação
// [
//     'name' => 'O campo name é obrigatório.',
//     'email' => 'O campo email deve conter um email válido.',
//     'password' => 'O campo password deve conter no mínimo 8 caracteres.'
// ]

```

### Condições para validar

```php

// Tudo oque vier depois da condition só será validado se a condição for atendida
$validate->validate([
    'email' => ['condition:filled', 'email']
    'email' => ['condition:empty', 'required']
]);

```

### Validações personalizadas

Todas as validações personalizadas devem ser definidas antes da instanciação da classe.

```php

Validate::extend('string', function($key, $value) {

    if (!is_string($value))
    {
        return Message::get('string', $key);
    }

    // A validação deve rotornar uma mensagem em caso de erro
    // ou true em caso de aprovação

    return true;

});

// Usando a validação personalizada

$validate->validate([
    'name' => ['string'],
]);

```

### Mensagens

#### Exemplo do arquivo de mensagens.

```php

'required' => 'O campo :attribute é obrigatório.',
'email' => 'O campo :attribute deve conter um email válido.',
'unique' => 'O :attribute já foi usado.',
'max' => [
    'string' => 'O campo :attribute deve conter no máximo :max caracteres.',
    'file' => 'O arquivo :attribute deve ter o tamanho máximo de :max.'
],

```

#### Pegando as mensagens.

```php

// Mensagens simples.
Message::get('required', attribute: $key);

// Mensagens que possuem tipos e um parâmetro.
// resultado: O campo $key deve conter no máximo $max caracteres.
Message::get(['max' => 'string'], attribute: $key, parameter: $max);

```

### Mensagens personalizadas

O componente possui um arquivo com as mensagens em "resources/language/pt-br/validation.php". Se você quiser criar suas próprias mensagens, não edite o arquivo existente, copie o arquivo e use os padrões do mesmo como exemplo. Use a constante MESSAGES_FILE_PATH para informar o novo caminho do seu arquivo personalizado.

```php

// Mensagens simples
'exists' => 'O :attribute não existe.',

// Mensagens que possuem tipos e um parâmetro.
// O parâmetro deve ter o mesmo nome da chave principal
'max' => [
    'string' => 'O campo :attribute deve conter no máximo :max caracteres.',
    'file' => 'O arquivo :attribute deve ter o tamanho máximo de :max.'
],

```

Você também pode personalizar os atributos dinâmicamente.

```php

// Informe primeiro o valor atual do atributo e depois o valor
// que irá substiruir o valor original.

'attributes' => [
    'name' => 'nome',
    'email' => 'e-mail',
    'password' => 'senha'
],

```


### Requisitos

- PHP 8.0 ou superior

