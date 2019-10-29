<?php

namespace app\controller;

use navic\Controller;
use CoffeeCode\Uploader\Image;
use NokitaKaze\RandomString\RandomString;

class FileController extends Controller {

    /**
     * Директория с загрузками
     */
    const DIR = 'uploads';

    /**
     * Показ изображения
     *
     * @param string $path Путь до файла
     * @return void
     */
    public function indexAction($path)
    {
        $file = __DIR__ . '/../../../' . self::DIR . '/' . $path;
        $ext = pathinfo($file, PATHINFO_EXTENSION);

        switch ($ext) {
            case "gif": $ctype="image/gif"; break;
            case "png": $ctype="image/png"; break;
            case "jpeg":
            case "jpg": $ctype="image/jpeg"; break;
            default:
        }

        header('Content-type: ' . $ctype);
        readfile($file);
        exit();
    }

    /**
     * Загрузка изображения
     *
     * @return void
     */
    public function uploadAction()
    {
        if ($_FILES) {
            $image = new Image(__DIR__ . '/../../../' . self::DIR, "images", 600);
            try {
                $upload = basename($image->upload($_FILES['upload'], mb_strtolower(RandomString::generate(24))));
                if ($upload) {
                    $result = (object) [
                        'fileName' => $upload,
                        'uploaded' => 1,
                        'url' => FULL_BASE_URL . '/' . 
                                self::DIR . '/images/' . 
                                date('Y', time()) . '/' . 
                                date('m', time()) . '/' . 
                                $upload
                    ];
                    return (object)[
                        'code' => $this->code, 
                        'message' => $result
                    ];
                }
            } catch (Exception $e) {
                $this->code = 400;
                return (object)['code' => $this->code, 'message' => $e->getMessage()];
            }
        }
    }
}