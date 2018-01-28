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
    private $videoSliderDir;

    public function __construct($sliderDir, $videoSliderDir)
    {
        $this->sliderDir = $sliderDir;
        $this->videoSliderDir = $videoSliderDir;
    }

    public function uploadSlider(UploadedFile $file)
    {
        $fileName = $file->getClientOriginalName();

        $file->move($this->getSliderDir(), $fileName);

        return $fileName;
    }

    public function uploadSliderVideo(UploadedFile $file)
    {
        $fileName = $file->getClientOriginalName();

        $file->move($this->getVideoSliderDir(), $fileName);

        return $fileName;
    }

    public function getSliderDir()
    {
        return $this->sliderDir;
    }

    public function getVideoSliderDir()
    {
        return $this->videoSliderDir;
    }
}