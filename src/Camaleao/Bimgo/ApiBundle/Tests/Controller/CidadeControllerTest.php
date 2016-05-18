<?php

namespace Camaleao\Bimgo\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CidadeControllerTest extends WebTestCase
{

    static public $expected = array(
        '{"members":{"id":1,"acronym":"LKY","firstName":"Lucky","lastName":"Luke"}}',
        '{"members":{"id":1,"acronym":"JWN","firstName":"John","lastName":"Wayne"}}',
    );

    protected function assertJsonResponse($response, $statusCode = 200)
    {
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }

    public function testIndexAction()
    {

        $client = static::createClient();
        $crawler = $client->request('GET', '/cidades');
        dump($crawler);

        /*
        $fixtures = array('Acme\MemeberBundle\DataFixtures\ORM\LoadMemberData');
        $this->loadFixtures($fixtures);
        $members = LoadMemberData::$members;

        $route =  $this->getUrl('member_get', array('id' => $members[0]->getId(), '_format' => 'json'));

        $client = static::createClient();
        $client->request('GET', $route, array('ACCEPT' => 'application/json'));
        $response = $client->getResponse();
        $content = $response->getContent();

        $this->assertJsonResponse($response, 200);
        $this->assertEquals($expected[0] , $content);
        */
    }



    /*
    public function testAllAction()
    {
        $fixtures = array('Acme\MemeberBundle\DataFixtures\ORM\LoadMemberData');
        $this->loadFixtures($fixtures);
        $members = LoadMemberData::$members;
        $limit = 2;

        for($i=0; $i<$limit; $i++) {
            $route =  $this->getUrl('member_all', array('id' => $members[$i]->getId(), '_format' => 'json'));

            $client = static::cr
            eateClient();
            $client->request('GET', $route, array('ACCEPT' => 'application/json'));
            $response = $client->getResponse();
            $content = $response->getContent();

            $this->assertJsonResponse($response, 200);
            $this->assertEquals($expected[$i], $content);
        }
    }

    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/cidade/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /cidade/");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'camaleao_web_bimgobundle_cidade[field_name]'  => 'Test',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'camaleao_web_bimgobundle_cidade[field_name]'  => 'Foo',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }
    */
}
