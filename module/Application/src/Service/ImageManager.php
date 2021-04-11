<?php


namespace Application\Service;


class ImageManager
{
    private string $dirToSaveFull;
    private string $dirToSaveMin;

    public function setAlbumDir(int $id): string
    {
        $this->dirToSaveFull = './data/upload/' . $id . "/";
        $this->dirToSaveMin = './data/upload/' . $id . "/min/";
        return $this->dirToSaveFull;
    }

    public function getDirToSaveFull(): string
    {
        return $this->dirToSaveFull;
    }

    private function callDirException() {
        throw new \Exception('Не указана директория альбома' .
            error_get_last());
    }

    public function createDir() {
        if (!isset($this->dirToSaveFull)) {
            $this->callDirException();
        }

        if (!is_dir($this->dirToSaveFull)) {
            if (!mkdir($this->dirToSaveFull)) {
                throw new \Exception('Could not create directory for uploading fulls: ' .
                    error_get_last());
            }
        }

        if (!is_dir($this->dirToSaveMin)) {
            if (!mkdir($this->dirToSaveMin)) {
                throw new \Exception('Could not create directory for uploading mins: ' .
                    error_get_last());
            }
        }
    }

    public function getSavedMins()
    {
        if (!isset($this->dirToSaveMin)) {
            $this->callDirException();
        }

        if (!is_dir($this->dirToSaveMin)) {
            return [];
        }

        $files = [];
        $handle = opendir($this->dirToSaveMin);
        while (false !== ($entry = readdir($handle))) {

            if ($entry == '.' || $entry == '..')
                continue; // Пропускаем текущий и родительский каталоги.

            $files[] = $entry;
        }

        return $files;
    }


    public function getImagePathByName($fileName, bool $thumbnail)
    {
        if (!isset($this->dirToSaveFull)) {
            $this->callDirException();
        }

        $fileName = str_replace("/", "", $fileName);  // Убираем слеши.
        $fileName = str_replace("\\", "", $fileName); // Убираем обратные слеши.

        if ($thumbnail) {
            return $this->dirToSaveMin . $fileName;
        } else {
            return $this->dirToSaveFull . $fileName;
        }
    }


    public function getImageFileContent($filePath)
    {
        return file_get_contents($filePath);
    }


    public function getImageFileInfo($filePath)
    {
        if (!is_readable($filePath)) {
            return false;
        }

        $fileSize = filesize($filePath);
        $mimeType = mime_content_type($filePath);

//        $finfo = finfo_open(FILEINFO_MIME);
//        $mimeType = finfo_file($finfo, $filePath);
//        if ($mimeType === false)
//            $mimeType = 'application/octet-stream';


        return [
            'size' => $fileSize,
            'type' => $mimeType
        ];
    }


    public function moveUploadedFile(array $formData): bool {
        $tempFilePath = $formData['file']['tmp_name'];
        $imageName = $formData['imageName'];
        $targetDir = $this->setAlbumDir($formData['albumId']);
        $this->createDir();
        $targetPath = $targetDir . $imageName . '.jpg';

        if (move_uploaded_file($tempFilePath, $targetPath) === false) {
            return false;
        }

        $this->createResizedImage($targetPath);
        return true;
    }


    public function createResizedImage(string $filePath, int $desiredWidth = 240): void
    {
        list($originalWidth, $originalHeight) = getimagesize($filePath);

        $aspectRatio = $originalWidth / $originalHeight;
        $desiredHeight = $desiredWidth / $aspectRatio;

        $fileInfo = $this->getImageFileInfo($filePath);

        $resultingImage = imagecreatetruecolor($desiredWidth, $desiredHeight);
        if (substr($fileInfo['type'], 0, 9) == 'image/png')
            $originalImage = imagecreatefrompng($filePath);
        else
            $originalImage = imagecreatefromjpeg($filePath);
        imagecopyresampled($resultingImage, $originalImage, 0, 0, 0, 0,
            $desiredWidth, $desiredHeight, $originalWidth, $originalHeight);

        $this->createDir();
        $resizedFilePath = dirname($filePath) . "/min";
        $resizedFilePath .= "/" . basename($filePath);

        imagejpeg($resultingImage, $resizedFilePath, 80);
    }
}