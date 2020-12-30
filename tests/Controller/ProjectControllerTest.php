<?php
namespace App\Tests\Controller;

use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Entity\Project;
use App\Entity\Promotion;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use App\Tests\DataProvider;

class ProjectControllerTest extends WebTestCase
{

    public function testProjectIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/project');
        $client->followRedirect();

        $this->assertResponseIsSuccessful();
    }

    public function testProjectNew()
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('robert@castel.fr');

        $crawler = $client->request('GET', '/project/new');
        $client->followRedirect();
        // Connexion
        $client->loginUser($testUser);

        $this->assertResponseIsSuccessful();
    }

    public function testProjectEditByProjectMember()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $projectRepository = static::$container->get(ProjectRepository::class);

        $testUser = $userRepository->findOneByEmail('robert@castel.fr');
        $project = $projectRepository->findOneByUser($testUser, 1)[0];
        // Connexion
        $client->loginUser($testUser);

        $crawler = $client->request('GET', sprintf('/project/%d/edit', $project->getId()));
        $this->assertResponseIsSuccessful();
    }

    /**
     * Vérifie si un utilisateur ne peut pas modifier le projet d'un autre utilisateur.
     * @return [type] [description]
     */
    public function testProjectEditByNonProjectMember(){
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $projectRepository = static::$container->get(ProjectRepository::class);

        $testUser = $userRepository->findOneByEmail('robert@castel.fr');
        $otherUser = $userRepository->findOneByEmail('claude@bieme.fr');
        $project = $projectRepository->find($otherUser->getProjects()->first());

        // Connexion
        $client->loginUser($testUser);
        $crawler = $client->request('GET', sprintf('/project/%d/edit', $project->getId()));

        $this->assertResponseStatusCodeSame(403);
    }

    /**
     * Vérifie si un administrateur peut modifier un projet existant.
     * @return [type] [description]
     */
    public function testProjectEditByAdminUser(){
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $projectRepository = static::$container->get(ProjectRepository::class);

        $testUser = $userRepository->findOneByEmail('admin@eseo.fr');
        $otherUser = $userRepository->findOneByEmail('claude@bieme.fr');
        $project = $projectRepository->find($otherUser->getProjects()->first());

        // Connexion
        $client->loginUser($testUser);
        $crawler = $client->request('GET', sprintf('/project/%d/edit', $project->getId()));

        $this->assertResponseStatusCodeSame(403);
    }

    public function testProjectShowNotLoggedIn(){
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $projectRepository = static::$container->get(ProjectRepository::class);

        $otherUser = $userRepository->findOneByEmail('claude@bieme.fr');
        $project = $projectRepository->find($otherUser->getProjects()->first());

        $crawler = $client->request('GET', sprintf('/project/%d', $project->getId()));

        $this->assertResponseStatusCodeSame(200);
    }

    public function testProjectShowLoggedIn(){
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $projectRepository = static::$container->get(ProjectRepository::class);

        $testUser = $userRepository->findOneByEmail('claude@bieme.fr');
        $project = $projectRepository->find($testUser->getProjects()->first());

        $client->loginUser($testUser);
        $crawler = $client->request('GET', sprintf('/project/%d', $project->getId()));

        $this->assertResponseStatusCodeSame(200);
    }
}
