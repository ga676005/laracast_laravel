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

    'accepted' => 'The :attribute field must be accepted.',
    'accepted_if' => 'The :attribute field must be accepted when :other is :value.',
    'active_url' => 'The :attribute field must be a valid URL.',
    'after' => 'The :attribute field must be a date after :date.',
    'after_or_equal' => 'The :attribute field must be a date after or equal to :date.',
    'alpha' => 'The :attribute field must only contain letters.',
    'alpha_dash' => 'The :attribute field must only contain letters, numbers, dashes, and underscores.',
    'alpha_num' => 'The :attribute field must only contain letters and numbers.',
    'any_of' => 'The :attribute field is invalid.',
    'array' => 'The :attribute field must be an array.',
    'ascii' => 'The :attribute field must only contain single-byte alphanumeric characters and symbols.',
    'before' => 'The :attribute field must be a date before :date.',
    'before_or_equal' => 'The :attribute field must be a date before or equal to :date.',
    'between' => [
        'array' => 'The :attribute field must have between :min and :max items.',
        'file' => 'The :attribute field must be between :min and :max kilobytes.',
        'numeric' => 'The :attribute field must be between :min and :max.',
        'string' => 'The :attribute field must be between :min and :max characters.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'can' => 'The :attribute field contains an unauthorized value.',
    'confirmed' => 'The :attribute field confirmation does not match.',
    'contains' => 'The :attribute field is missing a required value.',
    'current_password' => 'The password is incorrect.',
    'date' => 'The :attribute field must be a valid date.',
    'date_equals' => 'The :attribute field must be a date equal to :date.',
    'date_format' => 'The :attribute field must match the format :format.',
    'decimal' => 'The :attribute field must have :decimal decimal places.',
    'declined' => 'The :attribute field must be declined.',
    'declined_if' => 'The :attribute field must be declined when :other is :value.',
    'different' => 'The :attribute field and :other must be different.',
    'digits' => 'The :attribute field must be :digits digits.',
    'digits_between' => 'The :attribute field must be between :min and :max digits.',
    'dimensions' => 'The :attribute field has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'doesnt_contain' => 'The :attribute field must not contain any of the following: :values.',
    'doesnt_end_with' => 'The :attribute field must not end with one of the following: :values.',
    'doesnt_start_with' => 'The :attribute field must not start with one of the following: :values.',
    'email' => 'The :attribute field must be a valid email address.',
    'ends_with' => 'The :attribute field must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => '所選的 :attribute 無效。',
    'extensions' => 'The :attribute field must have one of the following extensions: :values.',
    'file' => 'The :attribute field must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'array' => 'The :attribute field must have more than :value items.',
        'file' => 'The :attribute field must be greater than :value kilobytes.',
        'numeric' => 'The :attribute field must be greater than :value.',
        'string' => 'The :attribute field must be greater than :value characters.',
    ],
    'gte' => [
        'array' => 'The :attribute field must have :value items or more.',
        'file' => 'The :attribute field must be greater than or equal to :value kilobytes.',
        'numeric' => 'The :attribute field must be greater than or equal to :value.',
        'string' => 'The :attribute field must be greater than or equal to :value characters.',
    ],
    'hex_color' => 'The :attribute field must be a valid hexadecimal color.',
    'image' => 'The :attribute field must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field must exist in :other.',
    'in_array_keys' => 'The :attribute field must contain at least one of the following keys: :values.',
    'integer' => 'The :attribute field must be an integer.',
    'ip' => 'The :attribute field must be a valid IP address.',
    'ipv4' => 'The :attribute field must be a valid IPv4 address.',
    'ipv6' => 'The :attribute field must be a valid IPv6 address.',
    'json' => 'The :attribute field must be a valid JSON string.',
    'list' => 'The :attribute field must be a list.',
    'lowercase' => 'The :attribute field must be lowercase.',
    'lt' => [
        'array' => 'The :attribute field must have less than :value items.',
        'file' => 'The :attribute field must be less than :value kilobytes.',
        'numeric' => 'The :attribute field must be less than :value.',
        'string' => 'The :attribute field must be less than :value characters.',
    ],
    'lte' => [
        'array' => 'The :attribute field must not have more than :value items.',
        'file' => 'The :attribute field must be less than or equal to :value kilobytes.',
        'numeric' => 'The :attribute field must be less than or equal to :value.',
        'string' => 'The :attribute field must be less than or equal to :value characters.',
    ],
    'mac_address' => 'The :attribute field must be a valid MAC address.',
    'max' => [
        'array' => ':attribute 欄位不能超過 :max 個項目。',
        'file' => ':attribute 欄位不能超過 :max KB。',
        'numeric' => ':attribute 欄位不能超過 :max。',
        'string' => ':attribute 欄位不能超過 :max 個字元。',
    ],
    'max_digits' => 'The :attribute field must not have more than :max digits.',
    'mimes' => 'The :attribute field must be a file of type: :values.',
    'mimetypes' => 'The :attribute field must be a file of type: :values.',
    'min' => [
        'array' => ':attribute 欄位至少要有 :min 個項目。',
        'file' => ':attribute 欄位至少要有 :min KB。',
        'numeric' => ':attribute 欄位至少為 :min。',
        'string' => ':attribute 欄位至少要有 :min 個字元。',
    ],
    'min_digits' => 'The :attribute field must have at least :min digits.',
    'missing' => 'The :attribute field must be missing.',
    'missing_if' => 'The :attribute field must be missing when :other is :value.',
    'missing_unless' => 'The :attribute field must be missing unless :other is :value.',
    'missing_with' => 'The :attribute field must be missing when :values is present.',
    'missing_with_all' => 'The :attribute field must be missing when :values are present.',
    'multiple_of' => 'The :attribute field must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute field format is invalid.',
    'numeric' => ':attribute 欄位必須為數字。',
    'password' => [
        'letters' => 'The :attribute field must contain at least one letter.',
        'mixed' => 'The :attribute field must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'The :attribute field must contain at least one number.',
        'symbols' => 'The :attribute field must contain at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present' => 'The :attribute field must be present.',
    'present_if' => 'The :attribute field must be present when :other is :value.',
    'present_unless' => 'The :attribute field must be present unless :other is :value.',
    'present_with' => 'The :attribute field must be present when :values is present.',
    'present_with_all' => 'The :attribute field must be present when :values are present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_if_accepted' => 'The :attribute field is prohibited when :other is accepted.',
    'prohibited_if_declined' => 'The :attribute field is prohibited when :other is declined.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'The :attribute field format is invalid.',
    'required' => ':attribute 欄位為必填。',
    'required_array_keys' => ':attribute 欄位必須包含以下項目：:values。',
    'required_if' => '當 :other 為 :value 時，:attribute 欄位為必填。',
    'required_if_accepted' => '當 :other 被接受時，:attribute 欄位為必填。',
    'required_if_declined' => '當 :other 被拒絕時，:attribute 欄位為必填。',
    'required_unless' => '除非 :other 在 :values 中，否則 :attribute 欄位為必填。',
    'required_with' => '當 :values 存在時，:attribute 欄位為必填。',
    'required_with_all' => '當 :values 都存在時，:attribute 欄位為必填。',
    'required_without' => '當 :values 不存在時，:attribute 欄位為必填。',
    'required_without_all' => '當 :values 都不存在時，:attribute 欄位為必填。',
    'same' => ':attribute 欄位必須與 :other 相符。',
    'size' => [
        'array' => ':attribute 欄位必須包含 :size 個項目。',
        'file' => ':attribute 欄位必須為 :size KB。',
        'numeric' => ':attribute 欄位必須為 :size。',
        'string' => ':attribute 欄位必須為 :size 個字元。',
    ],
    'starts_with' => ':attribute 欄位必須以以下其中一個開頭：:values。',
    'string' => ':attribute 欄位必須為字串。',
    'timezone' => 'The :attribute field must be a valid timezone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'uppercase' => 'The :attribute field must be uppercase.',
    'url' => 'The :attribute field must be a valid URL.',
    'ulid' => 'The :attribute field must be a valid ULID.',
    'uuid' => 'The :attribute field must be a valid UUID.',

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

    'attributes' => [
        'title' => '職缺標題',
        'employer_id' => '雇主',
        'salary_usd' => '薪資 (USD)',
        'salary_twd' => '薪資 (TWD)',
    ],

];
