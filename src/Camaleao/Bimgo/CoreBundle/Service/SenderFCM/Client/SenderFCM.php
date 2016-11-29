<?php

namespace Camaleao\Bimgo\CoreBundle\Service\SenderFCM\Client;

use Camaleao\Bimgo\CoreBundle\Service\SenderFCM\Entity\Message;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class SenderFCM {
    // url utilizada para o envio de mensagens a um ou vários dispositivos, e para tópicos
    const DEFAULT_API_URL = 'https://fcm.googleapis.com/fcm/send';

    // url utilizada para adicionar uma inscrição a um tópico
    const DEFAULT_TOPIC_ADD_SUBSCRIPTION_API_URL = 'https://iid.googleapis.com/iid/v1:batchAdd';

    // url utilizada para remover uma inscrição de um tópico
    const DEFAULT_TOPIC_REMOVE_SUBSCRIPTION_API_URL = 'https://iid.googleapis.com/iid/v1:batchRemove';

    /**
     * Usado para serializar em json a mensagem.
     *
     * @var Serializer $serializer
     */
    private $serializer;

    /**
     * Usado para preencher o cabeçalho da requisição.
     *
     * @var array $header
     */
    private $header;

    /**
     * SenderFCM constructor.
     *
     * @param $firebase_api_key
     */
    public function __construct($firebase_api_key)
    {
        $this->header = array
        (
            'Authorization: key=' . $firebase_api_key,
            'Content-Type: application/json'
        );

        // configura o serializer
        $encoder = array(new JsonEncoder());
        $normalizer = array(new GetSetMethodNormalizer());

        $this->serializer = new Serializer($normalizer, $encoder);
    }

    /**
     * @param Message $message
     *
     * @return string/json
     */
    private function buildMessage(Message $message)
    {
        $messageJson = $this->serializer->serialize($message, 'json');

        $messageJson = preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?|,"[^"]+":\[\]|"[^"]+":\[\],?/', '', $messageJson);

        return $messageJson;
    }

    /**
     * @param Message $message
     *
     * @param array $registration_ids
     *
     * @return string/json
     */
    private function buildMulticastMessage(Message $message, $registration_ids)
    {
        $message->setRegistration_ids($registration_ids);

        $messageJson = $this->serializer->serialize($message, 'json');

        $messageJson = preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?|,"[^"]+":\[\]|"[^"]+":\[\],?/', '', $messageJson);

        return $messageJson;
    }

    /**
     * Função para enviar uma mensagem FCM.
     *
     * @param Message $message
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function send(Message $message)
    {
        if ($message->getTo() && $message->getRegistrationIds())
            throw new \Exception('Ambos \'to\' e \'registration_ids\' foram preenchidos.');

        // verificar se existe apenas um registration id em $registration_ids e passar para $to
        if (count($message->getRegistrationIds()) == 1) {
            $message->setTo($message->getRegistrationIds()[0]);

            $message->setRegistrationIds(null);
        }

        if ($message->getTo() && $message->getTopic())
            throw new \Exception('Ambos \'to\' e \'topic\' foram preenchidos.');

        // verificar se existe tópico em $topic e passar para $to
        if ($message->getTopic()) {
            $message->setTo($message->getTopic());

            $message->setTopic(null);
        }

        if ($message->getTo()) {
            $messageJson = $this->buildMessage($message);

            $response = $this->sendByCurl($messageJson);

            return $response;
        }

        if ($message->getRegistrationIds()) {
            $array_registration_ids = array_chunk($message->getRegistration_ids(), 1000);
            $response = array();

            foreach ($array_registration_ids as $registration_ids) {
                $messageJson = $this->buildMulticastMessage($message, $registration_ids);

                $response[] = $this->sendByCurl($messageJson);
            }

            return $response;
        }
    }

    /*public function subscribeToTopic($topic, $registration_tokens)
    {
        return $this->processTopicSubscription($topic, $registration_tokens, self::DEFAULT_TOPIC_ADD_SUBSCRIPTION_API_URL);
    }

    public function unsubscribeToTopic($topic, $registration_tokens)
    {
        return $this->processTopicSubscription($topic, $registration_tokens, self::DEFAULT_TOPIC_ADD_SUBSCRIPTION_API_URL);
    }

    protected function processTopicSubscription($topic, $registration_tokens, $url)
    {
        if (!is_array($registration_tokens))
            $registration_tokens = [$registration_tokens];
        return $this->guzzleClient->post(
            $url,
            [
                'headers' => [
                    'Authorization' => sprintf('key=%s', $this->apiKey),
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode([
                    'to' => '/topics/' . $topic_id,
                    'registration_tokens' => $registration_tokens,
                ])
            ]
        );
    }
    */

    /**
     * Função para enviar a mensagem via curl.
     *
     * @param string $messageJson
     */
    private function sendByCurl($messageJson) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::DEFAULT_API_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $messageJson);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}