<?php

namespace OneBrasil;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->configuration = new Configuration;
    }

    public function testUsername()
    {
        $username = 'one_brasil';
        $this->configuration->username = $username;
        $this->assertEquals($username, $this->configuration->username);
    }

    public function testPassword()
    {
        $password = 'one_brasil';
        $this->configuration->password = $password;
        $this->assertEquals($password, $this->configuration->password);
    }

    public function testApiUrl()
    {
        $api_url = 'one_brasil';
        $this->configuration->api_url = $api_url;
        $this->assertEquals($api_url, $this->configuration->api_url);
    }
}