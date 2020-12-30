<?php
namespace App\Tests;

use App\Entity\User;
use App\Entity\Project;
use App\Entity\Promotion;
/**
 *
 */
class DataProvider
{
    private $faker;

    public function __construct(){
        $this->faker = Faker\Factory::create('fr_FR');
    }

    public function provideUser(array $roles = ["ROLE_STUDENT"]){
        $user = new User();
        $user->setFirstname($this->faker->firstName);
        $user->setLastname($this->faker->lastName);
        $user->setEmail($this->faker->safeEmail);
        $user->setRoles($roles);

        return $user;
    }

    public function providePromotion(){
        $year = $this->faker->datetime;
        $promotion = new Promotion();
        $promotion->setName("Promotion ".$this->faker->name);
        $promotion->setStartingYear(new \DateTimeImmutable($year));
        $promotion->setGraduationYear(new \DateTimeImmutable($year+5));

        return $promotion;
    }

    public function provideProject(array $users, $promotion){
        $project = new Project();
        $project->setName($this->faker->sentence());
        $project->setDescription($this->faker->realText());
        $project->setCost(55.67);
        $project->setViews(3567);
        foreach($users as $user){
          $project->addUser($user);
        }
        $project->setPromotion($promotion);
        $project->setGithubUrl($this->faker->url);
        return $project;
    }
}

?>
