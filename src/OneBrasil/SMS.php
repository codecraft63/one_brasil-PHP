<?php

namespace OneBrasil;

use Buzz\Browser;

class SMS
{
    private $config;

    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    public function send(Message $message)
    {
        $message->isValid();
        $code = $this->execute($message);

        switch ($code) {
            case 200:
                return TRUE;
            
            case 403:
                throw new AuthException;

            case 400:
                throw new BadRequestException;

            default:
                throw new \Exception("HTTP ERROR, Code: $code");
        }
    }

    protected function execute(Message $message)
    {
        $params = array(
            'to' => $message->getPhoneNumber(),
            'text' => $message->getBody(),
            'username' => $this->config->username,
            'password' => $this->config->password,
        );

        $query = http_build_query($params);

        $url = $this->config->api_url . '?' . $query;

        $broser = new Browser;
        $response = $broser->get($url);
        return $response->getStatusCode();
    }
}

class AuthException extends \Exception {}
class BadRequestException extends \Exception {}