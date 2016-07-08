<?php

namespace Camaleao\Bimgo\CoreBundle\Twig\Extension;

use Aws\S3\S3Client;

class LogotipoExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction('logotipo', array($this, 'logotipoFunction')),
        );
    }

    public function logotipoFunction($id, $nomeFantasia, $delimiter='-')
    {
        setlocale(LC_CTYPE, 'en_US.UTF-8');

        $text = $id."-".$nomeFantasia;

        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);


        if($this->s3Cliente->doesObjectExist('bim-go', "logotipos/$text.png"))
            return $this->s3Cliente->getObjectUrl('bim-go', "logotipos/$text.png");

        return $this->s3Cliente->getObjectUrl('bim-go', "logotipos/default.png");
    }

    public function getName()
    {
        return 'app_extension';
    }
}