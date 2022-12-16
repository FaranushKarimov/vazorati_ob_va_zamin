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

    'accepted' => 'Атрибут :attribute должен быть принят.',
    'active_url' => 'Атрибут :attribute не является допустимым URL-адресом.',
    'after' => 'Атрибут :attribute должен быть датой после :date.',
    'after_or_equal' => 'Атрибут :attribute должен содержать дату после или равную :date.',
    'alpha' => 'Атрибут :attribute может содержать только буквы.',
    'alpha_dash' => 'Атрибут :attribute может содержать только буквы, цифры, тире и символы подчеркивания.',
    'alpha_num' => 'Атрибут :attribute может содержать только буквы и цифры.',
    'array' => 'Атрибут :attribute должен быть массивом.',
    'before' => 'Атрибут :attribute должен быть датой перед :date.',
    'before_or_equal' => 'Атрибут :attribute должен быть датой, предшествующей или равной :date.',
    'between' => [
        'numeric' => 'Атрибут :attribute должен находиться между :min и :max.',
        'file' => 'Атрибут :attribute должен находиться в диапазоне от :min до :max килобайт.',
        'string' => 'Атрибут :attribute должен находиться между символами :min и :max.',
        'array' => 'Атрибут :attribute должен содержать элементы :min и :max.',
    ],
    'boolean' => 'Поле :attribute должно быть true или false.',
    'confirmed' => 'Подтверждение :attribute не совпадает.',
    'date' => 'Атрибут :attribute не является допустимой датой.',
    'date_equals' => 'Атрибут :attribute должен быть датой, равной :date.',
    'date_format' => 'Атрибут :attribute не соответствует формату :format.',
    'different' => 'Атрибут :attribute и :other должны отличаться.',
    'digits' => 'Атрибут :attribute должен содержать цифры :digits.',
    'digits_between' => 'Атрибут :attribute должен находиться между цифрами :min и :max.',
    'dimensions' => 'Атрибут :attribute имеет недопустимые размеры изображения.',
    'distinct' => 'Поле :attribute имеет повторяющееся значение.',
    'email' => 'Атрибут :attribute должен быть действительным адресом электронной почты.',
    'exists' => 'Выбранный атрибут :attribute является недопустимым.',
    'file' => 'Атрибут :attribute должен быть файлом.',
    'filled' => 'Поле :attribute должно иметь значение.',
    'gt' => [
        'numeric' => 'Атрибут :attribute должен быть больше, чем :value.',
        'file' => 'Атрибут :attribute должен быть больше килобайта :value.',
        'string' => 'Атрибут :attribute должен быть больше символов :value.',
        'array' => 'Атрибут :attribute должен содержать более :value элементов.',
    ],
    'gte' => [
        'numeric' => 'Атрибут :attribute должен быть больше или равен :value.',
        'file' => 'Атрибут :attribute должен быть больше или равен :value килобайт.',
        'string' => 'В :attribute должен быть больше или равен __увеличение символов.',
        'array' => 'Атрибут :attribute должен содержать элементы :value или более.',
    ],
    'image' => 'Атрибут :attribute должен быть изображением.',
    'in' => 'Выбранный атрибут :attribute является недопустимым.',
    'in_array' => 'Поле :attribute не существует в :other.',
    'integer' => 'Атрибут :attribute должен быть целым числом.',
    'ip' => 'Атрибут :attribute должен быть действительным IP-адресом.',
    'ipv4' => 'Атрибут :attribute должен быть допустимым адресом IPv4.',
    'ipv6' => 'Атрибут :attribute должен быть допустимым адресом IPv6.',
    'json' => 'Атрибут :attribute должен быть допустимой строкой JSON.',
    'lt' => [
        'numeric' => 'Атрибут :attribute должен быть меньше :value.',
        'file' => 'Атрибут :attribute должен быть меньше :value килобайт.',
        'string' => 'Атрибут :attribute должен быть меньше символов :value.',
        'array' => 'Атрибут :attribute должен содержать меньше элементов :value.',
    ],
    'lte' => [
        'numeric' => 'Атрибут :attribute должен быть меньше или равен :value.',
        'file' => 'Атрибут :attribute должен быть меньше или равен :value килобайт.',
        'string' => 'В :attribute должен быть меньше или равен __увеличение символов.',
        'array' => 'Атрибут :attribute не должен содержать более элементов :value.',
    ],
    'max' => [
        'numeric' => 'Атрибут :attribute не может быть больше :max.',
        'file' => 'Атрибут :attribute не может превышать :max килобайт.',
        'string' => 'Атрибут :attribute не может быть больше символов :max.',
        'array' => 'Атрибут :attribute может содержать не более :max элементов.',
    ],
    'mimes' => 'В :attribute должен быть файл типа__Х :values.',
    'mimetypes' => 'В :attribute должен быть файл типа__Х :values.',
    'min' => [
        'numeric' => 'Атрибут :attribute должен быть не менее :min.',
        'file' => 'Атрибут :attribute должен содержать не менее :min килобайт.',
        'string' => 'Атрибут :attribute должен содержать не менее :min символов.',
        'array' => 'Атрибут :attribute должен содержать по крайней мере элементы :min.',
    ],
    'not_in' => 'Выбранный атрибут :attribute является недопустимым.',
    'not_regex' => 'Недопустимый формат :attribute.',
    'numeric' => 'Атрибут :attribute должен быть числом.',
    'present' => 'Поле :attribute должно присутствовать.',
    'regex' => 'Недопустимый формат :attribute.',
    'required' => 'Поле :attribute является обязательным.',
    'required_if' => 'Поле :attribute требуется, если :other равно :value.',
    'required_unless' => 'Поле :attribute является обязательным, если :other не находится в :values.',
    'required_with' => 'Поле :attribute является обязательным, если присутствует :values.',
    'required_with_all' => 'Поле :attribute является обязательным, если присутствуют :values.',
    'required_without' => 'Поле :attribute требуется, если :values отсутствует.',
    'required_without_all' => 'Поле :attribute является обязательным, если ни одно из :values не присутствует.',
    'same' => 'Атрибут :attribute и :other должны совпадать.',
    'size' => [
        'numeric' => 'Атрибут :attribute должен быть :size.',
        'file' => 'Атрибут :attribute должен быть :size в килобайтах.',
        'string' => 'Атрибут :attribute должен содержать символы :size.',
        'array' => 'Атрибут :attribute должен содержать элементы :size.',
    ],
    'starts_with' => 'Атрибут :attribute должен начинаться с одного из следующих значений: :',
    'string' => 'Атрибут :attribute должен быть строкой.',
    'timezone' => 'Атрибут :attribute должен быть допустимой зоной.',
    'unique' => 'Атрибут :attribute уже был взят.',
    'uploaded' => 'Не удалось загрузить атрибут :attribute.',
    'url' => 'Недопустимый формат :attribute.',
    'uuid' => 'Атрибут :attribute должен быть допустимым идентификатором UUID.',

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
            'rule-name' => 'пользовательское сообщение',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
