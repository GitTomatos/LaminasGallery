<?php


namespace Application\Form;

use Application\Filter\AddAlbumFilter;
use Laminas\Form\Form;

class AddAlbumForm extends Form
{
    public function __construct()
    {
        parent::__construct("addAlbum");
//    public function init()
//    {
        $this->setAttribute('method', 'post');
//        $this->setInputFilter(new AddAlbumFilter());


//        $this->add([
//            'name' => 'post',
//            'type' => AlbumFieldset::class,
//        ]);
//        dump(new AlbumFieldset());
//        dd($this->getObject());
        $this->add([
            'type' => 'Application\Form\AlbumFieldset',
            'options' => [
                'use_as_base_fieldset' => true,
            ]
        ]);


//        $this->add([
//            'name' => 'name',
//            'attributes' => [
//                'type' => 'text',
//                'class' => 'form-control',
//                'id' => 'name',
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
//                'value' => 'Добавить',
//            ],
//        ]);
    }

}