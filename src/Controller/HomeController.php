<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProjectRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }
}
