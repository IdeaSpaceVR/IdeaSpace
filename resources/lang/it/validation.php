<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'Il :attribute deve essere accettato.',
    'active_url'           => 'Il :attribute non è un URL valido.',
    'after'                => 'Il :attribute deve essere uan data prima di :data.',
    'alpha'                => 'Il :attribute può contenere solo lettere.',
    'alpha_dash'           => 'Il :attribute può contenere solo letter, numeri, e trattini.',
    'alpha_num'            => 'Il :attribute può contenere solo letter e numeri.',
    'array'                => 'Il :attribute deve essere un array.',
    'before'               => 'Il :attribute deve essere un data prima di :date.',
    'between'              => [
        'numeric' => 'Il :attribute deve essere compreso tra :min e :max.',
        'file'    => 'Il :attribute deve essere compreso tra :min e :max kilobytes.',
        'string'  => 'Il :attribute deve essere compreso tra :min e :max caratteri.',
        'array'   => 'Il :attribute deve essere compreso tra :min e :max elementi.',
    ],
    'boolean'              => 'Il campo :attribute deve essere vero o falso.',
    'confirmed'            => 'La conferma :attribute non corrisponde.',
    'date'                 => 'Il :attribute non è una valida data.',
    'date_format'          => 'Il :attribute non corrisponde al formato :formato.',
    'different'            => 'Il :attribute e :other devonon essere diversi.',
    'digits'               => 'Il :attribute deve essere :digits digits.',
    'digits_between'       => 'Il :attribute deve essere compreso tra :min e :max digits.',
    'email'                => 'Il :attribute deve essere un valido indirizzo e-mail.',
    'exists'               => 'Il :attribute selezionato non è valido.',
    'filled'               => 'Il campo :attribute è richiesto.',
    'image'                => 'Il :attribute deve essere un immagine.',
    'in'                   => 'Il :attribute selezionato non è valido.',
    'integer'              => 'Il :attribute deve essere un numero intero.',
    'ip'                   => 'Il :attribute deve essere un indirizzo IP valido.',
    'json'                 => 'Il :attribute deve essere una valida JSON string.',
    'max'                  => [
        'numeric' => 'Il :attribute non deve essere più grande di :max.',
        'file'    => 'Il :attribute non deve essere più grande di :max kilobytes.',
        'string'  => 'Il :attribute non deve essere più grande di :max caratteri.',
        'array'   => 'Il :attribute non deve essere più grande di :max elementi.',
    ],
    'mimes'                => 'Il :attribute deve essere un file di tipo :values.',
    'min'                  => [
        'numeric' => 'Il :attribute deve essere almeno :min.',
        'file'    => 'Il :attribute deve essere almeno :min kilobytes.',
        'string'  => 'Il :attribute deve essere almeno :min caratteri.',
        'array'   => 'Il :attribute deve essere almeno :min elementi.',
    ],
    'not_in'               => 'Il :attribute selezionato non è valido.',
    'numeric'              => 'Il :attribute deve essere un numero.',
    'regex'                => 'Il formato di :attribute non è valido.',
    'required'             => 'Il campo :attribute è richiesto.',
    'required_if'          => 'Il campo :attribute è richiesto quando :other è :values.',
    'required_unless'      => 'Il campo :attribute è richiesto a meno che un :other è :values.',
    'required_with'        => 'Il campo :attribute è richiesto quando :values è presente.',
    'required_with_all'    => 'Il campo :attribute è richiesto quando tutti :values sono presenti.',
    'required_without'     => 'Il campo :attribute è richiesto quando :values non è presente.',
    'required_without_all' => 'Il campo :attribute è richiesto quando nessun :values sono presenti.',
    'same'                 => 'Il :attribute e :other devono corrispondere.',
    'size'                 => [
        'numeric' => 'Il :attribute deve essere :size.',
        'file'    => 'Il :attribute deve essere :size kilobytes.',
        'string'  => 'Il :attribute deve essere :size caratteri .',
        'array'   => 'Il :attribute deve contenere :size elementi.',
    ],
    'string'               => 'Il :attribute deve essere una corda.',
    'timezone'             => 'Il :attribute deve essere una zona valida.',
    'unique'               => 'Il :attribute è già stato usato.',
    'url'                  => 'Il formato :attribute non è valido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
