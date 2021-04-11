<?php


namespace Application\Controller;


use Application\Form\ImageForm;
use Application\Repository\AlbumRepository;
use Application\Service\ImageManager;
use Laminas\Form\Element;
use Laminas\InputFilter\InputFilter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ImageController extends AbstractActionController
{
    private AlbumRepository $albumRepository;
    private ImageManager $imageManager;

    // Метод конструктора используется для внедрения зависимостей
    // в контроллер.

    public function __construct(ImageManager $imageManager, AlbumRepository $albumRepository)
    {
        $this->imageManager = $imageManager;
        $this->albumRepository = $albumRepository;
    }

    // Это действие контроллера "index" (действие по умолчанию). Оно отображает
    // страницу Image Gallery, которая содержит список выгруженных изображений.
    public function indexAction()
    {
        // Получаем список уже сохраненных файлов.
        $albumId = $this->params()->fromRoute('albumId');
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


        if (!$this->params()->fromRoute('albumId')) {
            $albums = $this->albumRepository->findAll();
            $selectValues = [];

            foreach ($albums as $album) {
                $selectValues[$album->getId()] = $album->getName();
            }

            $form->get('albumId')->setValueOptions($selectValues);
        } else {
            $form->remove('albumId');
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

//                $albumId = $this->params()->fromRoute('albumId')
//                    ? $this->params()->fromRoute('albumId')
//                    : $data['albumId'];

                $formData = $form->getData();

                if (!isset($formData['albumId'])) {
                    $formData['albumId'] = $this->params()->fromRoute('albumId');
                }

                // Перемещаем выгруженный файл в его каталог назначения.
//                $tempFilePath = $form->getData()['file']['tmp_name'];
//                $fileName = $form->getData()['imageName'];


//                $targetDir = $this->imageManager->setAlbumDir($albumId);
//                $this->imageManager->createDir();
//                $imageFileType = strtolower(pathinfo($tempFilePath,PATHINFO_EXTENSION));

//                $targetPath = $targetDir . $fileName . '.jpg';


//                if (move_uploaded_file($tempFilePath, $targetPath)) {
////                    dd(is_file($form->getData()['file']['tmp_name']));
//                    $this->imageManager->createResizedImage($targetPath);
//                    return $this->redirect()->toRoute('images', ['albumId' => $albumId]);
//                }

                if ($this->imageManager->moveUploadedFile($formData)) {
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

    public function fileAction()
    {
        $albumId = $this->params()->fromRoute('albumId');
        $this->imageManager->setAlbumDir($albumId);
        // Получаем имя файла из GET-переменной.
        $fileName = $this->params()->fromQuery('name', '');
        $isThumbnail = (bool)$this->params()->fromQuery('thumbnail', false);

//        if ($isThumbnail) {
//            $fileName = $fileName;
//        }
//        dd($fileName);
        $fileName = $this->imageManager->getImagePathByName($fileName, $isThumbnail);
//        dd($fileName);
//        // Получаем информацию файла изображения (размер и MIME-тип).
        $fileInfo = $this->imageManager->getImageFileInfo($fileName);

        if ($fileInfo === false) {
            // Устанавливаем код состояния 404 Not Found
            $this->getResponse()->setStatusCode(404);
            return;
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