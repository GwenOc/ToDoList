<?php

namespace Tests\AppBundle\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserControllerTest extends WebTestCase
{
     private $client = null;

    private $em;
    private $newUser;

    protected $user;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->em = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $this->newUser = uniqid();
        $this->logIn();
    }

    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url, $expected)
    {
        $this->client->request('GET', $url);
        $this->assertSame($expected, $this->client->getResponse()->getStatusCode());
    }

    public function urlProvider()
    {
        return [
            ['/users', 200],
        ];
    }

    public function testCreateAction()
    {
        $crawler = $this->client->request('GET', '/users/create');
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = $this->newUser;
        $form['user[password][first]'] = $this->newUser;
        $form['user[password][second]'] = $this->newUser;
        $form['user[email]'] = $this->newUser . '@gdpweb.fr';
        $form['user[roles]'] = ['ROLE_ADMIN'];
        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect());
    }

    public function testEditAction()
    {
        $userManager = $this->em->getRepository('App:User');
        /** @var User $user */
        $user = $userManager->findOneBy(['username' => 'Gwenspirit']);
        $crawler = $this->client->request('GET', '/users/' . $user->getId() . '/edit');
        $form['user[password][first]'] = 'todolist';
        $form['user[password][second]'] = 'todolist';
        $form = $crawler->selectButton('Modifier')->form();
        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect());
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');
        $firewall = 'main';
        $token = new UsernamePasswordToken('admin', null, $firewall, ['ROLE_ADMIN']);
        $session->set('_security_' . $firewall, serialize($token));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}