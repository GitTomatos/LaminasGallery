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

//        $this->albumId = $albumId;

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
            'name' => 'imageName',
            'options' => [
                'label' => 'Название картинки',
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
                [
                    'name' => 'FileSize',
                    'options' => [
                        'max' => '20MB'
                    ]
                ],
            ],
            'filters'  => [
                [
                    'name' => 'FileRenameUpload',
                    'options' => [
//                        'target'=>"./data/upload/" . $this->albumId . "/",
//                        'useUploadName'=>true,
//                        'useUploadExtension'=>true,
                        'overwrite'=>true,
                        'randomize'=>false
                    ]
                ]
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