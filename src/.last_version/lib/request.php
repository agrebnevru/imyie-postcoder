<?php

namespace Imyie\Postcoder;

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Web\HttpClient;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class Request
{

    public $data = [];
    public $response = '';

    function __construct(string $url)
    {
        if (empty($url)) {
            throw new \Exception(Loc::getMessage('IMTIE_LIB_REQUEST_EXCEPTION_EMPTY_URL'));
        }

        $this->httpClient = new HttpClient();

        $this->httpClient->setHeader('Content-Type', 'application/json');
        // $this->httpClient->setHeader('Accept', 'application/json');

        $this->url = $url;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getData4Post()
    {
        return json_encode($this->getData());
    }

    public function getData4Get()
    {
        return http_build_query($this->getData());
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function post(): void
    {
        $this->response = $this->httpClient->post($this->getUrl(), $this->getData4Post());
    }

    public function get(): void
    {
        $this->response = $this->httpClient->get($this->getUrl().'?'.$this->getData4Get());
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getResponseArray()
    {
        return json_decode($this->getResponse(), true);
    }

}
