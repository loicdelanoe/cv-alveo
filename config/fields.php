<?php

return [
    'type' => ['text', 'repeater', 'image', 'video', 'gallery', 'markdown', 'collection', 'textarea', 'checkbox', 'file', 'date', 'time', 'datetime', 'color'],

    /*
    |--------------------------------------------------------------------------
    | Define validation rules for fields
    |--------------------------------------------------------------------------
    */
    'validation' => [
        'text' => ['string'],
        'textarea' => ['string'],
        'checkbox' => ['boolean'],
        'radio' => ['string'],
        'select' => ['string'],
        'file' => ['file'],
        'date' => ['date'],
        'time' => ['time'],
        'datetime' => ['date'],
        'color' => ['string'],
        'repeater' => ['array'],
        'gallery' => ['array'],
        // 'image' => ['file', 'image'],
    ],
];
