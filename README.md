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

```

### Mensagens

```php

Message::get('required', attribute: $key);
// Mensagem: 'required' => 'O campo :attribute é obrigatório.'
// Resultado: O campo $key é obrigatório.

// Em alguns casos deve-se informa a chave principal da mensagem
// e o tipo do dado. Algumas mensagens possuem um segundo parâmetro
// que sempre terá o mesmo nome da chave principal da mensagem

Message::get(['max' => 'string'], attribute: $key, parameter: $max);

// 'max' => [
//     'string' => 'O campo :attribute deve conter no máximo :max caracteres.',
//     'file' => 'O arquivo :attribute deve ter o tamanho máximo de :max.'
// ],

// resultado: O campo $key deve conter no máximo $max caracteres.

```

### Mensagens personalizadas

O componente possui um arquivo com as mensagens. Se você quiser criar suas próprias mensagens, copie o arquivo já existente e use os padrões do mesmo como exemplo. Use a constante MESSAGES_FILE_PATH para informar o novo caminho do seu arquivo personalizado (O caminho deve ser absoluto).

```php

// Mensagens simples
'exists' => 'O :attribute não existe.',

// Mensagens diferentes para cada tipo de dado
// Algumas mensagens precisam de um segundo parâmetro,
// esse parâmetro deve ter o mesmo nome da chave principal
'max' => [
    'string' => 'O campo :attribute deve conter no máximo :max caracteres.',
    'file' => 'O arquivo :attribute deve ter o tamanho máximo de :max.'
],

// Você também pode mudar o nome de um atributo de sua escolha.
// Essa funcionalidade geralmente é usada para tradução.

// ['procurar' => 'substituir_por']

// 'attributes' => [
//     'name' => 'nome',
//     'email' => 'e-mail',
//     'password' => 'senha'
// ],

```


### Requisitos

- PHP 8.0 ou superior

