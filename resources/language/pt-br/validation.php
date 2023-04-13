<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Linhas de idioma de validação
    |--------------------------------------------------------------------------
    */

    'required' => 'O campo :attribute é obrigatório.',
    'email' => 'O campo :attribute deve conter um email válido.',
    'unique' => 'O :attribute já foi usado.',
    'exists' => 'O :attribute não existe.',

    'max' => [
        'string' => 'O campo :attribute deve conter no máximo :max caracteres.',
        'numeric' => 'O campo :attribute não deve ser maior que :max.',
        'file' => 'O arquivo :attribute deve ter o tamanho máximo de :max.'
    ],
    'min' => [
        'string' => 'O campo :attribute deve conter no mínimo :min caracteres.',
        'file' => 'O campo :attribute deve ter o tamanho mínimo de :min.'
    ],
    'specific' => [
        'string' => 'O campo :attribute deve conter :specific caracteres.',
        'file' => 'O campo :attribute deve ter o tamanho de :specific.'
    ],

    /*
    |--------------------------------------------------------------------------
    | Atributos de validação personalizados
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'name' => 'nome',
        'email' => 'e-mail',
        'password' => 'senha'
    ],

];