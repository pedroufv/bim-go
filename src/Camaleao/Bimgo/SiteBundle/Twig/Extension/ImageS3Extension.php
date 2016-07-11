<?php

namespace Camaleao\Bimgo\SiteBundle\Twig\Extension;

use Aws\S3\S3Client;

class ImageS3Extension extends \Twig_Extension
{

    private $s3Cliente;

    /**
     * LogotipoExtension constructor.
     * @param S3Client $s3Cliente
     */
    public function __construct(S3Client $s3Cliente)
    {
        $this->s3Cliente = $s3Cliente;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getImgS3', array($this, 'getImgS3Function')),
        );
    }

    public function getImgS3Function($key, $ext = 'png', $subfolder = 'web', $folder = 'img', $bucket = 'bim-go')
    {
        if($this->s3Cliente->doesObjectExist($bucket, "$folder/$subfolder/$key.$ext"))
            return $this->s3Cliente->getObjectUrl($bucket, "$folder/$subfolder/$key.$ext");

        return $this->s3Cliente->getObjectUrl($bucket, "$folder/$subfolder/default.png");
    }

    public function getName()
    {
        return 'image_s3_extension';
    }
}