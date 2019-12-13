<?php

namespace App\tests\FonctionnalTests\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class TaskControllerTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        $firewallName = 'secure_area';
        // if you don't define multiple connected firewalls, the context defaults to the firewall name
        // See https://symfony.com/doc/current/reference/configuration/security.html#firewall-context
        $firewallContext = 'secured_area';

        // you may need to use a different token class depending on your application.
        // for example, when using Guard authentication you must instantiate PostAuthenticationGuardToken
        $token = new UsernamePasswordToken('admin', null, $firewallName, ['ROLE_ADMIN']);
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    public function testList()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', '/');
        $this->assertContains('/tasks', $crawler->filter('a')->extract(['href']));

        $link = $crawler->selectLink('Consulter la liste des tâches à faire')->link();
        $crawler = $this->client->click($link);
        $this->assertEquals($crawler->filter('thumbnail')->count(),0);
    }

    public function testCreate()
    {
        $this->logIn();
        $crawler = $this->client->request('GET','/');
        $this->assertContains('/tasks/create',$crawler->filter('a')->extract(['href']));

        $link = $crawler->selectLink('Créer une nouvelle tâche')->link();
        $crawler = $this->client->click($link);
        $this->assertSame(1, $crawler->filter('html:contains("Retour à la liste des tâches")')->count());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Fête';
        $form['task[content]'] = 'Préparer l\'anniversaire de Robin';
        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect());
    }
}
