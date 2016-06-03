<?php

namespace Camaleao\Bimgo\CoreBundle\Service;

use Camaleao\Bimgo\CoreBundle\Entity\Destinatariotipo;
use Doctrine\ORM\EntityManager;
use Endroid\Gcm\Client;

/**
 * PushMessage service.
 */
class PushNotification
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var array
     */
    protected $registrationIds = array();

    /**
     * @var array
     */
    protected $options = array(
        'collapse_key'=>'PushMessageBim-go',
        'delay_while_idle'=>false,
        'time_to_live'=>(4 * 7 * 24 * 60 * 60),
        'restricted_package_name'=>'br.com.camaleao.bim_go',
        'dry_run'=>false
    );


    /**
     * @param Client $client
     * @param EntityManager $em
     */
    public function __construct(Client $client, EntityManager $em)
    {
        $this->client = $client;
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getRegistrationIds()
    {
        return $this->registrationIds;
    }

    /**
     * @param array $registrationIds
     */
    public function setRegistrationIds($registrationIds)
    {
        $this->registrationIds = $registrationIds;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @param Destinatariotipo $destinatarioTipo
     */
    public function mountRecipientList(Destinatariotipo $destinatarioTipo)
    {

    }

    /**
     * send Notificacao
     */
    public function send()
    {
        if(empty($this->data) OR empty($this->registrationIds) OR empty($this->options))
            return false;

        return $this->client->send($this->data, $this->registrationIds, $this->options);
    }
}