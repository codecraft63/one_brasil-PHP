<?php

namespace OneBrasil;

class SMSTest extends \PHPUnit_Framework_TestCase
{
	protected function setUp()
	{
		$config = new Configuration;
		$config->username = 'one_brasil';
		$config->password = 'one_brasil';

		$this->config = $config;

		$message = $this->getMock('OneBrasil\Message', array(), array('123', 'Text'));
        $message->expects($this->any())
            	->method('isValid')
            	->will($this->returnValue(TRUE));

        $this->message = $message;
	}

	public function testValidMessage()
	{
		$sms = $this->getMock('OneBrasil\SMS', array('execute'), array($this->config));

		$sms->expects($this->once())
			->method('execute')
			->will($this->returnValue(200));

		$this->assertTrue($sms->send($this->message));
	}

	public function testAuthException()
	{
		$sms = $this->getMock('OneBrasil\SMS', array('execute'), array($this->config));

		$sms->expects($this->once())
			->method('execute')
			->will($this->returnValue(403));

		$this->setExpectedException('OneBrasil\AuthException');

		$sms->send($this->message);
	}

	public function testBadRequestException()
	{
		$sms = $this->getMock('OneBrasil\SMS', array('execute'), array($this->config));

		$sms->expects($this->once())
			->method('execute')
			->will($this->returnValue(400));

		$this->setExpectedException('OneBrasil\BadRequestException');
		
		$sms->send($this->message);
	}

	public function testOtherExceptions()
	{
		$sms = $this->getMock('OneBrasil\SMS', array('execute'), array($this->config));

		$sms->expects($this->once())
			->method('execute')
			->will($this->returnValue(500));

		$this->setExpectedException('Exception', "HTTP ERROR, Code: 500");
		
		$sms->send($this->message);
	}
}