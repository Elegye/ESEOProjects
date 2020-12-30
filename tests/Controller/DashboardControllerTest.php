<?php
namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DashboardControllerTest extends WebTestCase
{
    /**
     * Test de connexion au dashboard en tant qu'étudiant.
     * @return [type] [description]
     */
    public function testDashboardStudent()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('robert@castel.fr');
        // Connexion
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/dashboard');

        $this->assertResponseIsSuccessful();
    }

    /**
     * Test de connexion en tant qu'administrateur.
     */
    public function testDashboardAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@eseo.fr');
        // Connexion
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/dashboard');

        $this->assertResponseIsSuccessful();
    }
}
