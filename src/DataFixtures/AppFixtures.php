<?php
namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\User;
use App\Entity\Promotion;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $noether = new Promotion();
        $noether->setName("Noether");
        $noether->setStartingYear(new \DateTimeImmutable("2018"));
        $noether->setGraduationYear(new \DateTimeImmutable("2023"));
        $manager->persist($noether);

        $langevin = new Promotion();
        $langevin->setName("Langevin");
        $langevin->setStartingYear(new \DateTimeImmutable("2019"));
        $langevin->setGraduationYear(new \DateTimeImmutable("2024"));
        $manager->persist($langevin);

        $teacher = new User();
        $teacher->setRoles(["ROLE_ADMIN"]);
        $teacher->setFirstname("Bilel");
        $teacher->setLastname("Ben Boubaker");
        $teacher->setEmail("admin@eseo.fr");
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher,"admin"));
        $manager->persist($teacher);


        $student1 = new User();
        $student1->setRoles(["ROLE_STUDENT"]);
        $student1->setFirstname("Robert");
        $student1->setLastname("Castel");
        $student1->setEmail("robert@castel.fr");
        $student1->setPassword($this->passwordEncoder->encodePassword($student1,"robert"));
        $manager->persist($student1);

        $student2 = new User();
        $student2->setRoles(["ROLE_STUDENT"]);
        $student2->setFirstname("Bernard");
        $student2->setLastname("Chameau");
        $student2->setEmail("bernard@chameau.fr");
        $student2->setPassword($this->passwordEncoder->encodePassword($student2,"bernard"));
        $manager->persist($student2);

        $student3 = new User();
        $student3->setRoles(["ROLE_STUDENT"]);
        $student3->setFirstname("Claude");
        $student3->setLastname("Bieme");
        $student3->setEmail("claude@bieme.fr");
        $student3->setPassword($this->passwordEncoder->encodePassword($student3,"claude"));
        $manager->persist($student3);

        $student4 = new User();
        $student4->setRoles(["ROLE_STUDENT"]);
        $student4->setFirstname("Gontrand");
        $student4->setLastname("Limonade");
        $student4->setEmail("gontrand@limonade.fr");
        $student4->setPassword($this->passwordEncoder->encodePassword($student4,"gontrand"));
        $manager->persist($student4);

        $project1 = new Project();
        $project1->setName("Projet Arduino LEDs qui clignotent quand on baille");
        $project1->setDescription("Grâce à mon détecteur de baillement, je pense enfin à mettre ma main devant ma bouche.");
        $project1->setCost(123.45);
        $project1->setViews(1055);
        $project1->addUser($student1)->addUser($student2);
        $project1->setPromotion($noether);
        $project1->setGithubUrl("https://www.github.com");
        $manager->persist($project1);

        $project2 = new Project();
        $project2->setName("L'arnaque du siècle achetée sur Internet la veille des JPO");
        $project2->setDescription("J'étais vraiment très ambitieux au départ, mais ma procrastination m'a rattrapé à vitesse grand-V.\n Du coup j'ai utilisé mon abonnement Amazon Prime et fait acheminer jusqu'au pas de ma porte une superbe voiture télécommandée. Passé la phase de montage et le copier/coller du code, c'était nickel. \n J'ai pu continuer ma série Netflix.");
        $project2->setCost(55.67);
        $project2->setViews(3567);
        $project2->addUser($student3)->addUser($student4);
        $project2->setPromotion($langevin);
        $project2->setGithubUrl("https://www.github.com");
        $manager->persist($project2);

        $manager->flush();
    }
}
