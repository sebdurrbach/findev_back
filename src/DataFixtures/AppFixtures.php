<?php

namespace App\DataFixtures;

use App\Entity\Candidacy;
use Faker\Factory;
use App\Entity\Skill;
use App\Entity\Client;
use App\Entity\Project;
use App\Entity\DevSkill;
use App\Entity\Developper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        $faker->addProvider(new \Ottaviano\Faker\Gravatar($faker));

        $skillNames = ['PHP', 'Symfony', 'Cake', 'Laravel', 'Zend', 'Javascript', 'Jquery', 'Angular', 'React', 'Vue', 'HTML', 'CSS', 'SASS', 'Webpack', 'Java', 'Python', 'Ruby', 'C++', 'C#'];

        $skills = [];
        $developpers = [];
        $projects = [];

        foreach ($skillNames as $skillName) {
            $skill = new Skill();
            $skill->setName($skillName);
            $skills[] = $skill;

            $manager->persist($skill);
        }

        for ($c = 0; $c < 10; $c++) {
            $client = new Client();
            $client
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName)
                ->setEmail("client$c@gmail.com")
                ->setPassword($this->encoder->encodePassword($client, 'password'))
                ->setRoles(['CLIENT'])
                ->setCompany($faker->company);

            $project = new Project();
            $project
                ->setTitle("Site de {$client->getCompany()}")
                ->setClient($client)
                ->setDescription($faker->paragraphs($faker->numberBetween(3, 6), true))
                ->setMaxBudget($faker->numberBetween(400, 50000))
                ->setStatus('PENDING')
                ->setCreatedAt($faker->dateTimeBetween('-30 days'));

            for ($ps = 0; $ps < mt_rand(3, 7); $ps++) {
                $project->addSkill($faker->randomElement($skills));
            }

            $manager->persist($client);
            $manager->persist($project);

            $projects[] = $project;
        }

        for ($d = 0; $d < 25; $d++) {
            $developper = new Developper();
            $developper
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName)
                ->setImage($faker->gravatarUrl())
                ->setBio($faker->sentences(2, true))
                ->setPortfolio($faker->url)
                ->setGithub($faker->url)
                ->setRoles(['DEV'])
                ->setEmail("dev$d@gmail.com")
                ->setPassword($this->encoder->encodePassword($developper, 'password'));

            for ($ds = 0; $ds < mt_rand(2, 7); $ds++) {

                $devSkill = new DevSkill();
                $devSkill
                    ->setSkill($faker->randomElement($skills))
                    ->setLevel($faker->numberBetween(1, 5));

                $developper->addSkill($devSkill);

                $manager->persist($devSkill);
            }

            $developpers[] = $developper;
            $manager->persist($developper);
        }

        foreach ($projects as $p) {
            for ($cand = 0; $cand < mt_rand(3, 8); $cand++) {
                $candidacy = new Candidacy();
                $candidacy
                    ->setProject($p)
                    ->setDevelopper($faker->randomElement($developpers))
                    ->setBudget($faker->numberBetween(($p->getMaxBudget() / 2), $p->getMaxBudget()))
                    ->setDescription($faker->paragraphs($faker->numberBetween(1, 3), true))
                    ->setStatus('PENDING');

                $manager->persist($candidacy);
            }
        }

        $manager->flush();
    }
}
