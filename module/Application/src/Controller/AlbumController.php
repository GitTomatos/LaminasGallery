<?php


namespace Application\Controller;


use Application\Entity\Album;
use Application\Form\AddAlbumForm;
use Application\Form\EditAlbumForm;
use Application\Repository\AlbumRepository;
use Laminas\Config\Config;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\ServiceManager\ServiceManager;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\Adapter;

class AlbumController extends AbstractActionController
{

    private AlbumRepository $albumRepository;

    public function __construct(AlbumRepository $albumRepository)
    {
        $this->albumRepository = $albumRepository;
    }


    public function addAction()
    {

        $form = new AddAlbumForm();
        $form->setHydrator(new ReflectionHydrator());
        $form->bind(new Album());
//        dd($form->getObject());

        if ($this->getRequest()->isPost()) {
//            dd($this->getRequest()->getPost());

            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
//                dd($form->getData());
                $this->albumRepository->save($form->getData());

                $this->flashMessenger()->addSuccessMessage('Добавлено успешно');

                $this->redirect()->toRoute('home');
//                return new ViewModel([
//                    'wasAdded' => true,
//                    'form' => $form,
//                ]);
            }
        }
//        die();

//        $album = $this->albumRepository->findOneBy(["id" => 2]);
//        dump($album);


        return new ViewModel([
            'form' => $form,
        ]);
    }

    public function editAction() {
        $albumId = $this->params()->fromRoute('albumId');
        $album = $this->albumRepository->findOneBy(['id' => $albumId]);

        if (is_null($album)) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $form = new EditAlbumForm();
        $form->setHydrator(new ReflectionHydrator());
        $form->bind($album);
        $form->setObject($album);

        if ($this->getRequest()->isPost()) {
            $form ->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $editedAlbum = $form->getData();

                $this->albumRepository->save($editedAlbum);
                $this->flashMessenger()->addSuccessMessage('Изменено');
                return new ViewModel([
                    'form' => $form,
                ]);
            }

        }


        return new ViewModel([
            'form' => $form,
        ]);
    }

    public function deleteAction() {
        $albumId = $this->params()->fromRoute('albumId');
        if (is_null($this->albumRepository->find($albumId))) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $this->albumRepository->delete($albumId);
        $this->redirect()->toRoute('home');
    }

}