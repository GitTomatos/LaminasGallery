<?php


namespace Application\Form;

use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilterProviderInterface;

class AlbumFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('album');
//    public function init()
//    {

        $this->add([
            'name' => 'name',

            'attributes' => [
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'name',

            ],
            'options' => [
                'label' => 'Название альбома',
                'label_attributes' => [
                    'class' => 'form-label lbl',
                ],
            ]
        ]);

        $this->add([
            'name' => 'description',
            'attributes' => [
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'description',
            ],
            'options' => [
                'label' => 'Описание альбома',
                'label_attributes' => [
                    'class' => 'form-label lbl',
                ],
            ]
        ]);

        $this->add([
            'name' => 'photographer',
            'attributes' => [
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'photographer',
            ],
            'options' => [
                'label' => 'Имя фотографа',
                'label_attributes' => [
                    'class' => 'form-label lbl',
                ],
            ]
        ]);

        $this->add([
            'name' => 'email',
            'attributes' => [
                'type' => 'email',
                'class' => 'form-control',
                'id' => 'email',
            ],
            'options' => [
                'label' => 'Электронная почта',
                'label_attributes' => [
                    'class' => 'form-label lbl',
                ],
            ]
        ]);

        $this->add([
            'name' => 'phone',
            'attributes' => [
                'type' => 'phone',
                'class' => 'form-control',
                'id' => 'phone',
            ],
            'options' => [
                'label' => 'Номер телефона',
                'label_attributes' => [
                    'class' => 'form-label lbl',
                ],
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'class' => 'btn btn-primary btn-lg center',
                'value' => 'Добавить',
            ],
        ]);
    }

    public function getInputFilterSpecification(): array
    {
        return [
            'name' => [
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
            ],
            'description' => [
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
            ],
            'photographer' => [
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
            ],
            'email' => [
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
            ],
            'phone' => [
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
            ],
        ];
    }
}