<?php


namespace Application\Filter;


use Laminas\InputFilter\InputFilter;

class AddAlbumFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'name',
            'required' => true,
            'validators' => [
                [
                    'name' => 'Laminas\Validator\StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 50,
                        'messages' => [
                            \Laminas\Validator\StringLength::TOO_SHORT => "Должен быть хотя бы один символ",
                            \Laminas\Validator\StringLength::TOO_LONG => "Превышает допустимые %max% символов",
                        ]
                    ],

                ],
            ],
            'filters' => [
                [
                    'name' => 'Laminas\Filter\StripNewlines',
                ],
                [
                    'name' => 'Laminas\Filter\StringTrim',
                ],
                [
                    'name' => 'Laminas\Filter\StripTags',
                ],
            ],
        ]);

        $this->add([
            'name' => 'description',
            'required' => true,
            'validators' => [
                [
                    'name' => 'Laminas\Validator\StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 200,
                        'messages' => [
                            \Laminas\Validator\StringLength::TOO_SHORT => "Должен быть хотя бы один символ",
                            \Laminas\Validator\StringLength::TOO_LONG => "Превышает допустимые %max% символов",
                        ]
                    ],

                ]
            ],
            'filters' => [
                [
                    'name' => 'Laminas\Filter\StripNewlines',
                ],
                [
                    'name' => 'Laminas\Filter\StringTrim',
                ],
                [
                    'name' => 'Laminas\Filter\StripTags',
                ],
            ],
        ]);

        $this->add([
            'name' => 'photograph',
            'required' => true,
            'validators' => [
                [
                    'name' => 'Laminas\Validator\StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 50,
                        'messages' => [
                            \Laminas\Validator\StringLength::TOO_SHORT => "Должен быть хотя бы один символ",
                            \Laminas\Validator\StringLength::TOO_LONG => "Превышает допустимые %max% символов",
                        ]
                    ],
                ],
            ],
            'filters' => [
                [
                    'name' => 'Laminas\Filter\StripNewlines',
                ],
                [
                    'name' => 'Laminas\Filter\StringTrim',
                ],
                [
                    'name' => 'Laminas\Filter\StripTags',
                ],
            ],
        ]);

        $this->add([
            'name' => 'email',
            'required' => false,
            'validators' => [
                [
                    'name' => 'Laminas\Validator\StringLength',
                    'options' => [
                        'min' => 1,
                    ],
                ],
                [
                    'name' => 'Laminas\Validator\EmailAddress',
                    'options' => [
                        'messages' => [
                            \Laminas\Validator\EmailAddress::INVALID_HOSTNAME => "Неверный hostname: '%hostname%'",

                        ]
                    ],
                ],
            ],
            'filters' => [
                [
                    'name' => 'Laminas\Filter\StripNewlines',
                ],
                [
                    'name' => 'Laminas\Filter\StringTrim',
                ],
                [
                    'name' => 'Laminas\Filter\StripTags',
                ],
            ],
        ]);

        $this->add([

            'name' => 'phone',
            'required' => false,
            'validators' => [
                [
                    'name' => 'Laminas\Validator\Regex',
                    'options' => [
                        'pattern' => '/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}/',
                        'messages' => [
                            \Laminas\Validator\Regex::NOT_MATCH =>
                                'Телефон должен соответствовать шаблону +7 (234) 233-44-55',
                        ],
                    ],
                ],
            ],
            'filters' => [
                [
                    'name' => 'Laminas\Filter\StripNewlines',
                ],
                [
                    'name' => 'Laminas\Filter\StringTrim',
                ],
                [
                    'name' => 'Laminas\Filter\StripTags',
                ],
            ],
        ]);
    }
}