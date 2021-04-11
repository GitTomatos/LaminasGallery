<?php


namespace Application\Form;


use Application\Entity\Album;
use Application\Entity\Entity;
use Application\Filter\AddAlbumFilter;
use Laminas\Form\Form;

class EditAlbumForm extends Form
{
    public function __construct()
    {
        parent::__construct("editAlbum");

        $this->setAttribute('method', "post");
//        $this->setInputFilter(new AddAlbumFilter());

        $this->add([
            'type' => 'Application\Form\AlbumFieldset',
            'options' => [
                'use_as_base_fieldset' => true,
            ]
        ]);
//
//
//        $this->add([
//            'name' => 'name',
//            'attributes' => [
//                'type' => 'text',
//                'class' => 'form-control',
//                'id' => 'name',
//                'value' => $album->getName(),
//            ],
//            'options' => [
//                'label' => 'Название альбома',
//                'label_attributes' => [
//                    'class' => 'form-label lbl',
//                ],
//            ]
//        ]);
//
//        $this->add([
//            'name' => 'description',
//            'attributes' => [
//                'type' => 'text',
//                'class' => 'form-control',
//                'id' => 'description',
//                'value' => $album->getDescription(),
//            ],
//            'options' => [
//                'label' => 'Описание альбома',
//                'label_attributes' => [
//                    'class' => 'form-label lbl',
//                ],
//            ]
//        ]);
//
//        $this->add([
//            'name' => 'photograph',
//            'attributes' => [
//                'type' => 'text',
//                'class' => 'form-control',
//                'id' => 'photograph',
//                'value' => $album->getPhotograph(),
//            ],
//            'options' => [
//                'label' => 'Имя фотографа',
//                'label_attributes' => [
//                    'class' => 'form-label lbl',
//                ],
//            ]
//        ]);
//
//        $this->add([
//            'name' => 'email',
//            'attributes' => [
//                'type' => 'email',
//                'class' => 'form-control',
//                'id' => 'email',
//                'value' => $album->getEmail(),
//            ],
//            'options' => [
//                'label' => 'Электронная почта',
//                'label_attributes' => [
//                    'class' => 'form-label lbl',
//                ],
//            ]
//        ]);
//
//        $this->add([
//            'name' => 'phone',
//            'attributes' => [
//                'type' => 'phone',
//                'class' => 'form-control',
//                'id' => 'phone',
//                'value' => $album->getPhone(),
//            ],
//            'options' => [
//                'label' => 'Номер телефона',
//                'label_attributes' => [
//                    'class' => 'form-label lbl',
//                ],
//            ]
//        ]);
//
//        $this->add([
//            'name' => 'submit',
//            'attributes' => [
//                'type' => 'submit',
//                'class' => 'btn btn-primary btn-lg center',
//                'value' => 'Редактировать',
//            ],
//        ]);
    }
}