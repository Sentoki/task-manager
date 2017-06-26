<?php
declare(strict_types=1);

namespace app\common;

class FileUpload {
    const FILE_TYPES = [
        'image/png' => '.png',
        'image/jpeg' => '.jpg',
        'image/gif' => '.gif',
    ];

    public static function saveFile() : string
    {
        $uploadsDir = __DIR__ . '/../web/uploads/';
        $filename = md5(
            $_FILES['file']['tmp_name'] . time()
            ) . self::FILE_TYPES[$_FILES['file']['type']];
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadsDir . $filename)) {
            throw new \Exception('Ошибка загрузки файла');
        }
        self::resizeFile($filename);
        return $filename;
    }

    public static function resizeFile($filename)
    {
        $uploadsDir = __DIR__ . '/../web/uploads/';
        $size = getimagesize($uploadsDir . $filename);
        if ($size[0] > 320 || $size[1] > 240) {
            $ratioWidth = $size[0] / 320;
            $ratioHeight = $size[1] / 240;
            if ($ratioWidth > $ratioHeight) {
                $w = 320;
                $h = floor($size[1] / $ratioWidth);
            } else {
                $h = 240;
                $w = floor($size[0] / $ratioHeight);
            }

            if ($size['mime'] == 'image/jpeg') {
                $image = imagecreatefromjpeg($uploadsDir . $filename);
            } elseif ($size['mime'] == 'image/png') {
                $image = imagecreatefrompng($uploadsDir . $filename);
            } elseif ($size['mime'] == 'image/gif') {
                $image = imagecreatefromgif($uploadsDir . $filename);
            } else {
                throw new \Exception('Неожиданный тип изображения');
            }
            $new = imagecreatetruecolor((int)$w, (int)$h);
            imagecopyresized($new, $image, 0 ,0, 0, 0, (int)$w, (int)$h, (int)$size[0], (int)$size[1]);
            if ($size['mime'] == 'image/jpeg') {
                imagejpeg($new, $uploadsDir . $filename, 80);
            } elseif ($size['mime'] == 'image/png') {
                imagepng($new, $uploadsDir . $filename, 2);
            } elseif ($size['mime'] == 'image/gif') {
                imagegif($new, $uploadsDir . $filename);
            } else {
                throw new \Exception('Неожиданный тип изображения');
            }
        }
    }
}
