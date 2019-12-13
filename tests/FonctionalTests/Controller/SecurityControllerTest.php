<?php

namespace App\tests\FonctionnalTests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $this->assertEquals(1,$crawler->filter('form')->count());

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals($client->getResponse()->getStatusCode(), Response::HTTP_OK);

        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'Batman';
        $form['password'] = 'Robin';
        $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect());
    }

    public function testLogout()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/logout');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $this->assertSame(0, $crawler->filter('html:contains("Bienvenue sur ToDoList")')->count());
    }
}
