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
    private $categoryCoverDir;
    private $articleCoverDir;
    private $articleSecondCoverDir;
    private $articleThirdCoverDir;
    private $articleFourthCoverDir;

    public function __construct($sliderDir, $videoSliderDir, $categoryCoverDir, $articleCoverDir, $articleSecondCoverDir, $articleThirdCoverDir, $articleFourthCoverDir)
    {
        $this->sliderDir = $sliderDir;
        $this->videoSliderDir = $videoSliderDir;
        $this->categoryCoverDir = $categoryCoverDir;
        $this->articleCoverDir = $articleCoverDir;
        $this->articleSecondCoverDir = $articleSecondCoverDir;
        $this->articleThirdCoverDir = $articleThirdCoverDir;
        $this->articleFourthCoverDir = $articleFourthCoverDir;
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

    public function uploadCategoryCover(UploadedFile $file)
    {
        $fileName = $file->getClientOriginalName();

        $file->move($this->getCategoryCoverDir(), $fileName);

        return $fileName;
    }

    public function uploadArticleCover(UploadedFile $file)
    {
        $fileName = $file->getClientOriginalName();

        $file->move($this->getArticleCoverDir(), $fileName);

        return $fileName;
    }

    public function uploadArticleSecondCover(UploadedFile $file)
    {
        $fileName = $file->getClientOriginalName();

        $file->move($this->getArticleSecondCoverDir(), $fileName);

        return $fileName;
    }

    public function uploadArticleThirdCover(UploadedFile $file)
    {
        $fileName = $file->getClientOriginalName();

        $file->move($this->getArticleThirdCoverDir(), $fileName);

        return $fileName;
    }

    public function uploadArticleFourthCover(UploadedFile $file)
    {
        $fileName = $file->getClientOriginalName();

        $file->move($this->getArticleFourthCoverDir(), $fileName);

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

    private function getCategoryCoverDir()
    {
        return $this->categoryCoverDir;
    }

    private function getArticleCoverDir()
    {
        return $this->articleCoverDir;
    }

    private function getArticleSecondCoverDir()
    {
        return $this->articleSecondCoverDir;
    }
    private function getArticleThirdCoverDir()
    {
        return $this->articleThirdCoverDir;
    }
    private function getArticleFourthCoverDir()
    {
        return $this->articleFourthCoverDir;
    }
}