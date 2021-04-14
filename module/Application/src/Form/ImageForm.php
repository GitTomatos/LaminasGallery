<?php


namespace Application\Form;

use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\File;

class ImageForm extends Form
{
    private ?int $albumId;

    public function __construct()
    {
        parent::__construct('image-form');

        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->addInputFilter();
        $this->addElements();
    }

    protected function addElements()
    {
        $this->add([
            'type' => 'file',
            'name' => 'file',
            'attributes' => [
                'id' => 'file'
            ],
            'options' => [
                'label' => 'Image file',
            ],
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'name',
            'options' => [
                'label' => 'Название картинки',
            ],
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'address',
            'options' => [
                'label' => 'Адрес фотосъёмки:',
            ],
        ]);

        $this->add([
            'type' => 'select',
            'name' => 'albumId',
            'options' => [
                'label' => 'Выберите альбом',
            ],
        ]);

        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Загрузить',
                'id' => 'submitbutton',
            ],
        ]);
    }

    private function addInputFilter()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);
//        new \Laminas\InputFilter\FileInput();

        // Добавляем правила валидации для поля "file".
        $inputFilter->add([
            'type' => 'Zend\InputFilter\FileInput',
            'name' => 'file',
            'required' => true,
            'validators' => [
                ['name' => 'FileUploadFile'],
                [
                    'name' => 'FileMimeType',
                    'options' => [
                        'mimeType' => ['image/jpeg', 'image/png']
                    ]
                ],
                ['name' => 'FileIsImage'],
//                [
//                    'name' => 'Laminas\Validator\File\Count',
//                    'options' => [
//                        'max' => 1,
//                    ],
//                ],
//                [
//                    'name' => 'FileSize',
//                    'options' => [
//                        'max' => '20MB'
//                    ]
//                ],
            ],
//            'filters' => [
//                [
////                    new \Laminas\Filter\File\RenameUpload();
//                    'name' => 'FileRenameUpload',
//                    'options' => [
//                        'target'=>"./data/uploads/",
//                        'useUploadName'=>true,
//                        'useUploadExtension'=>true,
//                        'overwrite' => true,
//                        'randomize' => false
//                    ]
//                ]
//            ],
        ]);

        $inputFilter->add([
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

        $inputFilter->add([
            'name' => 'address',
            'required' => false,
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

        $inputFilter->add([
            'name' => 'albumId',
            'validators' => [
                ['name' => 'Digits'],
            ],
        ]);
    }
}