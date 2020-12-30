<?php
namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PromotionControllerTest extends WebTestCase
{
    public function testPromotionNotLoggedIn()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $crawler = $client->request('GET', '/promotion');

        $this->assertResponseRedirects();
    }

    public function testPromotionNewNotLoggedIn()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $crawler = $client->request('GET', '/promotion/new');

        $this->assertResponseRedirects();
    }

    public function testPromotionLoggedIn()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@eseo.fr');
        // Connexion
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/promotion');
        $client->followRedirect();

        $this->assertResponseStatusCodeSame(200);
    }

    public function testPromotionNewLoggedIn()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@eseo.fr');
        // Connexion
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/promotion/new');

        $this->assertResponseStatusCodeSame(200);
    }

    public function testPromotionByStudent()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('claude@bieme.fr');
        // Connexion
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/promotion');

        $this->assertResponseRedirects();
    }

    public function testPromotionNewByStudent()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('claude@bieme.fr');
        // Connexion
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/promotion/new');

        $this->assertResponseStatusCodeSame(403);
    }
}
