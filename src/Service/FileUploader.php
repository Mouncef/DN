<?php
/**
 * Created by PhpStorm.
 * User: Mouncef
 * Date: 20/01/2018
 * Time: 23:06
 */

namespace App\Service;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $sliderDir;

    public function __construct($sliderDir)
    {
        $this->sliderDir = $sliderDir;
    }

    public function uploadSlider(UploadedFile $file)
    {
        $fileName = $file->getClientOriginalName();

        $file->move($this->getSliderDir(), $fileName);

        return $fileName;
    }

    public function getSliderDir()
    {
        return $this->sliderDir;
    }
}