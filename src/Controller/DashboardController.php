<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Lorsqu'un utilisateur se connecte, il a accès à son dashboard.
 * @IsGranted("ROLE_STUDENT")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     * @return vue Liste des projets de l'utilisateur courant.
     */
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'projects' => $this->getUser()->getProjects(),
        ]);
    }
}
