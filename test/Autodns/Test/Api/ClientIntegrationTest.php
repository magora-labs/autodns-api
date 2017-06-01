<?php

namespace Autodns\Test\Api;

use Autodns\Api\Account\Info;
use Autodns\Api\Client;
use Autodns\Api\XmlDelivery;
use Autodns\Test\TestCase;
use Autodns\Tool\ArrayToXmlConverter;
use Autodns\Api\Client\Request\Task\Query;
use Autodns\Api\Client\Request;
use Autodns\Tool\XmlToArrayConverter;

class ClientIntegrationTest extends TestCase
{
    const SOME_URL = 'some url';

    /**
     * @test
     */
    public function itShouldMakeADomainInquireListCall()
    {
        $taskName = 'DomainInquireList';
        $responseXml = $this->getResponseXml($taskName);
        $expectedRequest = $this->getExpectedRequestXml($taskName);
        $expectedResult = new Client\Response(
            array(
                'result' => array(
                    'data' => array(
                        'summary' => '2',
                        'domain' => array(
                            array(
                                'owner' => array(
                                    'user' => 'customer',
                                    'context' => '4'
                                ),
                                'name' => 'example.com',
                                'created' => '2005-06-16 16:47:50'
                            ),
                            array(
                                'owner' => array(
                                    'user' => 'customer2',
                                    'context' => '4'
                                ),
                                'name' => 'example.com',
                                'created' => '2005-06-16 16:47:50',
                                'domainsafe' => 'true',
                                'dnssec' => 'false'
                            )
                        )
                    ),
                    'status' => array(
                        'text' => 'Domaindaten wurden erfolgreich ermittelt.',
                        'type' => 'success',
                        'code' => 'S0105'
                    )
                )
            )
        );

        $fakeResponse = $this->aStub('Buzz\Message\MessageInterface')->with('getContent', $responseXml);

        $sender = $this->aStub('Buzz\Browser')->with('post', $fakeResponse)->build();
        $sender
            ->expects($this->once())
            ->method('post')
            ->with($this->anything(), $this->anything(), $expectedRequest);

        $client = $this->buildClient($sender);

        $query = new Query();
        $query = $query->addOr(
            $query->addAnd(
                array('name', 'like', '*.at'),
                array('created', 'lt', '2012-12-*')
            ),
            array('name', 'like', '*.de')
        );

        $task = new Request\Task\DomainInquireList();
        $task->withView(array('offset' => 0, 'limit' => 20, 'children' => 0))
            ->withKeys(array('created', 'payable'))
            ->withQuery($query);

        $this->assertEquals($expectedResult, $client->call($task));
    }

    /**
     * @test
     */
    public function itShouldMakeADomainRecoverInquireCall()
    {
        $taskName = 'DomainRecoverInquire';

        $responseXml = $this->getResponseXml($taskName);
        $expectedRequest = $this->getExpectedRequestXml($taskName);

        $expectedResult = new Client\Response(
            array(
                'result' => array(
                    'data' => array(
                        'summary' => '1',
                        'restore' => array(
                            'name' => 'example.com',
                            'expire' => '2013-07-13 15:24:39',
                            'payable' => '2013-07-13 15:24:39',
                            'action' => 'RESTORE',
                            'owner' => array(
                                'user' => 'customer2',
                                'context' => '4'
                            ),
                            'created' => '2009-07-13 15:24:39'
                        )
                    ),
                    'status' => array(
                        'text' => 'Die wiederherstellbaren Domains wurden erfolgreich ermittelt.',
                        'type' => 'success',
                        'code' => 'S0105005'
                    )
                ),
                'stid' => '20130906-xxx-44444'
            )
        );

        $client = $this->buildClientAndExpectRequestToBeSended($responseXml, $expectedRequest);

        $query = new Query();
        $task = new Request\Task\DomainRecoverInquire();
        $task->withView(array('offset' => 0, 'limit' => 1, 'children' => 0))
            ->withKeys(array('created', 'payable', 'expire'))
            ->withQuery($query->addAnd(array('name', 'eq', 'example.com')));

        $this->assertEquals($expectedResult, $client->call($task));
    }

    /**
     * @test
     */
    public function itShouldMakeADomainRecoverCall()
    {
        $taskName = 'DomainRecover';

        $responseXml = $this->getResponseXml($taskName);
        $expectedRequest = $this->getExpectedRequestXml($taskName);

        $expectedResult = new Client\Response(
            array(
                'result' => array(
                    'data' => array(),
                    'status' => array(
                        'code' => 'N0101005',
                        'type' => 'notify',
                        'object' => array(
                            'type' => 'domain',
                            'value' => 'example.com'
                        )
                    )
                )
            )
        );

        $client = $this->buildClientAndExpectRequestToBeSended($responseXml, $expectedRequest);

        $task = new Request\Task\DomainRecover();
        $task
            ->domain('example.com')
            ->withCtid('some identifier')
            ->replyTo('some@body.com');

        $this->assertEquals($expectedResult, $client->call($task));
    }

    /**
     * @test
     */
    public function itShouldMakeADomainInquireCall()
    {
        $taskName = 'DomainInquire';

        $responseXml = $this->getResponseXml($taskName);
        $expectedRequest = $this->getExpectedRequestXml($taskName);

        $expectedResult = new Client\Response(
            array(
                'result' => array(
                    'data' => array(
                        'domain' => array(
                            'adminc' => '1224545',
                            'authinfo' => array(),
                            'autorenew' => 'true',
                            'name' => 'example.com',
                            'nserver' => array(
                                array('name' => 'ns1.example.com'),
                                array('name' => 'ns2.example.com'),
                            ),
                            'owner' => array(
                                'context' => '54',
                                'user' => 'username222',
                            ),
                            'ownerc' => '44554',
                            'payable' => '2012-11-11 11:44:33',
                            'period' => '1',
                            'status' => 'success',
                            'techc' => '445545',
                            'zonec' => '445545',
                            'created' => '2009-11-11 11:44:33'
                        )
                    ),
                    'status' => array(
                        'code' => 'S0105',
                        'text' => 'Domaindaten wurden erfolgreich ermittelt.',
                        'type' => 'success'
                    )
                )
            )
        );

        $client = $this->buildClientAndExpectRequestToBeSended($responseXml, $expectedRequest);

        $task = new Request\Task\DomainInquire();
        $task
            ->domain('example.com')
            ->withKeys(array('created', 'payable'));

        $this->assertEquals($expectedResult, $client->call($task));
    }

    /**
     * @test
     */
    public function itShouldMakeAHandleInquireCall()
    {
        $taskName = 'HandleInquire';

        $responseXml = $this->getResponseXml($taskName);
        $expectedRequest = $this->getExpectedRequestXml($taskName);

        $expectedResult = new Client\Response(
            array(
                'result' => array(
                    'data' => array(
                        'handle' => array(
                            'address' => 'Street',
                            'alias' => 'Somebody Who',
                            'city' => 'City',
                            'country' => 'UK',
                            'created' => '2009-11-11 11:43:35',
                            'domainsafe' => '0',
                            'email' => 'some@one.com',
                            'fname' => 'Somebody',
                            'id' => '1254545',
                            'lname' => 'Who',
                            'nic_ref' => array(
                                'name' => 'Some ref',
                                'nic' => 'uk',
                                'status' => 'success'
                            ),
                            'owner' => array(
                                'context' => '45',
                                'user' => 'customer',
                            ),
                            'pcode' => '12345',
                            'phone' => '12334545454',
                            'protection' => 'B',
                            'state' => 'UK',
                            'type' => 'PERSON'
                        )
                    ),
                    'status' => array(
                        'code' => 'S0304',
                        'text' => 'Domainkontakt-Daten wurden erfolgreich ermittelt.',
                        'type' => 'success'
                    )
                )
            )
        );

        $client = $this->buildClientAndExpectRequestToBeSended($responseXml, $expectedRequest);

        $task = new Request\Task\HandleInquire();
        $task
            ->handleId('1254545')
            ->alias('Somebody Who');

        $this->assertEquals($expectedResult, $client->call($task));
    }

    /**
     * @test
     */
    public function itShouldMakeAHandleCreateCall()
    {
        $taskName = 'HandleCreate';

        $responseXml = $this->getResponseXml($taskName);
        $expectedRequest = $this->getExpectedRequestXml($taskName);

        $expectedResult = new Client\Response(
            array(
                'result' => array(
                    'status' => array(
                        'code' => 'N0301',
                        'text' => 'Das Anlegen des Domainkontaktes wurde erfolgreich gestartet.',
                        'type' => 'notify',
                        'object' => array(
                            'type' => 'handle',
                            'value' => '9926612'
                        )
                    )
                )
            )
        );

        $client = $this->buildClientAndExpectRequestToBeSended($responseXml, $expectedRequest);

        $task = new Request\Task\HandleCreate();
        $task
            ->fill(array(
                'type' => 'PERSON',
                'fname' => 'Peter',
                'lname' => 'Muster',
                'organization' => 'PDA',
                'address' => 'Musterstrasse 3',
                'pcode' => '12345',
                'city' => 'Musterstadt',
                'country' => 'Deutschland',
                'phone' => '+49-12345-12345',
                'fax' => '+49-12345-12345',
            ))
            ->email('Muster@example.com')
            ->forceHandleCreate(true)
            ->replyTo('customer@example.com');

        $this->assertEquals($expectedResult, $client->call($task));
    }


    /**
     * @param $taskName
     * @return string
     */
    private function getResponseXml($taskName)
    {
        return file_get_contents(__DIR__ . '/testData/' . $taskName . '_response.xml');
    }

    /**
     * @param $taskName
     * @return string
     */
    private function getExpectedRequestXml($taskName)
    {
        return file_get_contents(__DIR__ . '/testData/' . $taskName . '_request.xml');
    }

    /**
     * @param $sender
     * @return Client
     */
    private function buildClient($sender)
    {
        $client = new Client(
            new XmlDelivery(
                new ArrayToXmlConverter(),
                $sender,
                new XmlToArrayConverter()
            ),
            new Info(self::SOME_URL, 'user', 'password', 4)
        );
        return $client;
    }

    /**
     * @param $responseXml
     * @param $expectedRequest
     * @return Client
     */
    private function buildClientAndExpectRequestToBeSended($responseXml, $expectedRequest)
    {
        $fakeResponse = $this->aStub('Buzz\Message\MessageInterface')->with('getContent', $responseXml);

        $sender = $this->aStub('Buzz\Browser')->with('post', $fakeResponse)->build();
        $sender
            ->expects($this->once())
            ->method('post')
            ->with($this->anything(), $this->anything(), $expectedRequest);

        $client = $this->buildClient($sender);
        return $client;
    }
}
