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

    'accepted' => ':attribute ត្រូវតែត្រូវបានទទួលយក។',
    'active_url' => ':attribute មិនមែនជា URL ត្រឹមត្រូវទេ។',
    'after' => ':attribute ត្រូវតែជាកាលបរិច្ឆេទក្រោយ :date.',
    'after_or_equal' => ':attribute ត្រូវតែជាកាលបរិច្ឆេទក្រោយឬស្មើ :date។',
    'alpha' => ':attribute អាចមានតែអក្សរប៉ុណ្ណោះ។',
    'alpha_dash' => ':attribute អាចមានតែអក្សរ, លេខ, សញ្ញា (_) និងសញ្ញាគូសក្រោមប៉ុណ្ណោះ។',
    'alpha_num' => ':attribute អាចមានតែអក្សរនិងលេខប៉ុណ្ណោះ។',
    'array' => ':attribute ត្រូវតែជាអារ៉េ។',
    'before' => ':attribute ត្រូវតែជាកាលបរិច្ឆេទមុន :date។',
    'before_or_equal' => ':attribute ត្រូវតែជាកាលបរិច្ឆេទមុនឬស្មើ :date។',
    'between' => [
        'numeric' => ':attribute ត្រូវតែនៅចន្លោះ :min ហើយ :max។',
        'file' => ':attribute ត្រូវតែនៅចន្លោះ :min និង :max គីឡូបៃ។',
        'string' => ':attribute ត្រូវតែនៅចន្លោះ :min និង :max តួអក្សរ។',
        'array' => ':attribute ត្រូវតែមានរវាង :min និង :max ធាតុ។',
    ],
    'boolean' => ':attribute វាលត្រូវតែពិតឬមិនពិត។',
    'confirmed' => ':attribute ការបញ្ជាក់មិនត្រូវគ្នា។',
    'date' => ':attribute មិនមែនជាកាលបរិច្ឆេទត្រឹមត្រូវទេ។',
    'date_equals' => ':attribute ត្រូវតែជាកាលបរិច្ឆេទស្មើ :date។',
    'date_format' => ':attribute មិនត្រូវគ្នានឹងទ្រង់ទ្រាយ :format។',
    'different' => ':attribute និង :other ត្រូវតែខុសគ្នា។',
    'digits' => ':attribute ត្រុវតែ :digits តួលេខ។',
    'digits_between' => ':attribute ត្រូវតែនៅចន្លោះ :min និង :max តួលេខ។',
    'dimensions' => ':attribute មានវិមាត្ររូបភាពមិនត្រឹមត្រូវ។',
    'distinct' => ':attribute វាលមានតម្លៃស្ទួនមួយ។',
    'email' => ':attribute ត្រូវតែជាអាសយដ្ឋានអ៊ីមែលត្រឹមត្រូវ។',
    'exists' => ':attribute ដែលបានជ្រើសរើសមិនត្រឹមត្រូវ។',
    'file' => ':attribute ត្រូវតែជាឯកសារ។',
    'filled' => ':attribute ត្រូវតែមានតម្លៃ។',
    'gt' => [
        'numeric' => ':attribute ត្រូវតែធំជាង :value។',
        'file' => ':attribute ត្រូវតែធំជាង :value គីឡូបៃ។',
        'string' => ':attribute ត្រូវតែធំជាង :value តួអក្សរ។',
        'array' => ':attribute ត្រូវតែមានច្រើនជាង :value ធាតុ។',
    ],
    'gte' => [
        'numeric' => ':attribute ត្រូវតែធំជាងឬស្មើ :value។',
        'file' => ':attribute ត្រូវតែធំជាងឬស្មើ :value គីឡូបៃ។',
        'string' => ':attribute ត្រូវតែធំជាងឬស្មើ :value តួអក្សរ។',
        'array' => ':attribute ត្រូវតែ​មាន :value ធាតុឬច្រើនទៀត។',
    ],
    'image' => ':attribute ត្រូវតែជារូបភាព។',
    'in' => ':attribute ដែលបានជ្រើសរើសមិនត្រឹមត្រូវ។',
    'in_array' => ':attribute មិនមាននៅក្នុង :other។',
    'integer' => ':attribute ត្រូវតែជាចំនួនគត់។',
    'ip' => ':attribute ត្រូវតែជាអាសយដ្ឋាន IP ត្រឹមត្រូវ។',
    'ipv4' => ':attribute ត្រូវតែជាអាសយដ្ឋាន IPv4 ត្រឹមត្រូវ។',
    'ipv6' => ':attribute ត្រូវតែជាអាសយដ្ឋាន IPv6 ត្រឹមត្រូវ។',
    'json' => ':attribute ត្រូវតែជាខ្សែអក្សរ JSON ត្រឹមត្រូវ។',
    'lt' => [
        'numeric' => ':attribute ត្រូវតែតិចជាង :value.',
        'file' => ':attribute ត្រូវតែតិចជាង :value គីឡូបៃ។',
        'string' => ':attribute ត្រូវតែតិចជាង :value តួអក្សរ។',
        'array' => ':attribute ត្រូវតែតិចជាង :value ធាតុ។',
    ],
    'lte' => [
        'numeric' => ':attribute ត្រូវតែតិចជាងឬស្មើ :value.',
        'file' => ':attribute ត្រូវតែតិចជាងឬស្មើ :value គីឡូបៃ។',
        'string' => ':attribute ត្រូវតែតិចជាងឬស្មើ :value តួអក្សរ។',
        'array' => ':attribute មិនត្រូវមានច្រើនជាង :value ធាតុ។',
    ],
    'max' => [
        'numeric' => ':attribute អាចនឹងមិនធំជាង :max.',
        'file' => ':attribute អាចនឹងមិនធំជាង :max គីឡូបៃ។',
        'string' => ':attribute អាចនឹងមិនធំជាង :max តួអក្សរ។',
        'array' => ':attribute អាចមិនមានច្រើនជាង :max ធាតុ។',
    ],
    'mimes' => ':attribute អាចមិនមានច្រើនជាង: :values។',
    'mimetypes' => ':attribute អាចមិនមានច្រើនជាង: :values។',
    'min' => [
        'numeric' => ':attribute ត្រូវតែយ៉ាងហោចណាស់ :min។',
        'file' => ':attribute ត្រូវតែយ៉ាងហោចណាស់ :min គីឡូបៃ។',
        'string' => ':attribute ត្រូវតែយ៉ាងហោចណាស់ :min តួអក្សរ។',
        'array' => ':attribute ត្រូវតែមានយ៉ាងហោចណាស់ :min ធាតុ។',
    ],
    'not_in' => ':attribute ដែលបានជ្រើសរើសមិនត្រឹមត្រូវ។',
    'not_regex' => ':attribute ទ្រង់ទ្រាយមិនត្រឹមត្រូវ។',
    'numeric' => ':attribute ត្រូវតែជាលេខ។',
    'present' => ':attribute វាលត្រូវតែមានវត្តមាន។',
    'regex' => ':attribute ទ្រង់ទ្រាយមិនត្រឹមត្រូវ។',
    'required' => ':attribute ទ្រង់ទ្រាយមិនត្រឹមត្រូវ។',
    'required_if' => ':attribute វាលត្រូវបានទាមទារនៅពេល :other គឺ :value។',
    'required_unless' => ':attribute វាលត្រូវបានទាមទារលុះត្រាតែ :other គឺនៅក្នុង :values។',
    'required_with' => ':attribute វាលត្រូវបានទាមទារនៅពេល :values មានវត្តមាន។',
    'required_with_all' => ':attribute វាលត្រូវបានទាមទារនៅពេល :values គឺមានវត្តមាន។',
    'required_without' => ':attribute វាលត្រូវបានទាមទារនៅពេល :values មិនមាន មានវត្តមាន។',
    'required_without_all' => ':attribute វាលត្រូវបានទាមទារនៅពេល ដែលមិនមាន :values គឺមានវត្តមាន។',
    'same' => ':attribute និង :other ត្រូវតែផ្គូផ្គង។',
    'size' => [
        'numeric' => ':attribute ត្រូវ​តែ​ជា :size។',
        'file' => ':attribute ត្រូវ​តែ​ជា :size គីឡូបៃ។',
        'string' => ':attribute ត្រូវ​តែ​ជា :size តួអក្សរ។',
        'array' => ':attribute ត្រូវតែមាន :size ធាតុ។',
    ],
    'starts_with' => ':attribute ត្រូវតែចាប់ផ្តើមជាមួយចំណុចណាមួយដូចខាងក្រោម: :values',
    'string' => ':attribute ត្រូវ​តែ​ជា ខ្សែអក្សរ។',
    'timezone' => ':attribute ត្រូវ​តែ​ជា តំបន់ត្រឹមត្រូវ។',
    'unique' => ':attribute ត្រូវបានគេយករួចហើយ។',
    'uploaded' => ':attribute បរាជ័យក្នុងការផ្ទុកឡើង។',
    'url' => ':attribute ទ្រង់ទ្រាយមិនត្រឹមត្រូវ។',
    'uuid' => ':attribute ត្រូវ​តែ​ជាទម្រង់ UUID។',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
