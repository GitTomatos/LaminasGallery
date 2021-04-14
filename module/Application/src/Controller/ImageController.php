<?php


namespace Application\Controller;


use Application\Entity\Image;
use Application\Form\ImageForm;
use Application\Repository\AlbumRepository;
use Application\Repository\ImageRepository;
use Application\Service\ImageManager;
use Laminas\Form\Element;
use Laminas\Form\FormInterface;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\InputFilter\InputFilter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ImageController extends AbstractActionController
{
    private AlbumRepository $albumRepository;
    private ImageRepository $imageRepository;
    private ImageManager $imageManager;

    // Метод конструктора используется для внедрения зависимостей
    // в контроллер.

    public function __construct(
        ImageManager $imageManager,
        AlbumRepository $albumRepository,
        ImageRepository $imageRepository
    )
    {
        $this->imageManager = $imageManager;
        $this->albumRepository = $albumRepository;
        $this->imageRepository = $imageRepository;
    }

    // Это действие контроллера "index" (действие по умолчанию). Оно отображает
    // страницу Image Gallery, которая содержит список выгруженных изображений.
    public function indexAction()
    {
        // Получаем список уже сохраненных файлов.
        $albumId = $this->params()->fromRoute('albumId');
        if (is_null($this->albumRepository->find($albumId))) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $this->imageManager->setAlbumDir($albumId);
        $files = $this->imageManager->getSavedMins();


        // Визуализируем шаблон представления.
        return new ViewModel([
            'files' => $files,
            'albumId' => $albumId,
        ]);
    }

    // Это действие показывает форму выгрузки изображений. Эта страница позволяет
    // выгрузить один файл на сервер.
    public function uploadAction()
    {
        // Создаем модель формы.
        $form = new ImageForm();
        $form->setHydrator(new ReflectionHydrator());
        $form->bind(new Image());

        if (!$this->params()->fromRoute('albumId')) {
            $albums = $this->albumRepository->findAll();
            $selectValues = [];

            foreach ($albums as $album) {
                $selectValues[$album->getId()] = $album->getName();
            }

            $form->get('albumId')->setValueOptions($selectValues);
        } else {
            $form->remove('albumId');
//            $form->getInputFilter()->remove('albumId');

            $hiddenAlbumId = new Element\Hidden('albumId');
            $hiddenAlbumId->setValue($this->params()->fromRoute('albumId'));
//
            $form->add($hiddenAlbumId);
        }



        if ($this->getRequest()->isPost()) {

            $request = $this->getRequest();
            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );


            $form->setData($data);

            // Валидируем форму.
            if ($form->isValid()) {

                $formData = $form->getData(FormInterface::VALUES_AS_ARRAY);

//                if (!isset($formData['albumId'])) {
//                    $formData['albumId'] = $this->params()->fromRoute('albumId');
//                }

                if ($this->imageManager->moveUploadedFile($formData)) {
                    $image = $form->getData();
                    $image->setExtension(pathinfo($formData['file']['name'], PATHINFO_EXTENSION));
                    $this->imageRepository->insert($image);
                    return $this->redirect()->toRoute('images', ['albumId' => $formData['albumId']]);
                } else {
                    echo "Ошибка загрузки";
                }

            }
//            dd($form);
        }

        // Визуализируем страницу.
        return new ViewModel([
            'form' => $form
        ]);
    }

    public function deleteAction()
    {
        $albumId = $this->params()->fromRoute('albumId');
        $photoName = $this->params()->fromQuery('photoName');
        $this->imageManager->deleteImage($albumId, $photoName);
        $this->redirect()->toRoute('images', ['albumId' => $albumId]);
    }

    public function fileAction()
    {
        $albumId = $this->params()->fromRoute('albumId');
        $this->imageManager->setAlbumDir($albumId);
        // Получаем имя файла из GET-переменной.
        $isThumbnail = (bool)$this->params()->fromQuery('thumbnail', false);

        $fileName = $this->params()->fromQuery('name', '');
        if ($fileName === '') {
            $lastImage = $this->imageRepository->findLast($albumId);
//            return;
            $fileName = $lastImage->getNameWithExtension();
        }

        $fileName = $this->imageManager->getImagePathByName($fileName, $isThumbnail);

        // Получаем информацию файла изображения (размер и MIME-тип).
        $fileInfo = $this->imageManager->getImageFileInfo($fileName);

        if ($fileInfo === false) {
            // Устанавливаем код состояния 404 Not Found
            $this->getResponse()->setStatusCode(404);
            return $this->getResponse();
        }


        $response = $this->getResponse();
        $headers = $response->getHeaders();
        $headers->addHeaderLine("Content-type: " . $fileInfo['type']);
        $headers->addHeaderLine("Content-length: " . $fileInfo['size']);

        // Записываем содержимое файла.

        $fileContent = $this->imageManager->getImageFileContent($fileName);

        if ($fileContent !== false) {
            $response->setContent($fileContent);
        } else {
            // Устанавливаем код состояния 500 Server Error.
            $this->getResponse()->setStatusCode(500);
            return;
        }

        // Возвращаем экземпляр Response, чтобы избежать визуализации представления по умолчанию.
        return $this->getResponse();
    }
}