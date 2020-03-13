<?php

namespace App\DataFixtures;

use App\Entity\UserEntity;
use App\Entity\Article;
use App\Entity\Home;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

	// ...
	private $encoder;

	public function __construct(UserPasswordEncoderInterface $encoder)
	{
	    $this->encoder = $encoder;
	}

    public function load(ObjectManager $manager)
    {
        $this->loadUser($manager);
        $this->loadHome($manager);

    	$manager->flush();
    }

    public function loadUser(ObjectManager $manager)
    {
        $user = new UserEntity();
        $user->setUsername('admin6Team');

        $password = $this->encoder->encodePassword($user, '6teamAdmin75');
        $user->setPassword($password);
        $roles[] = 'ROLE_ADMIN';
        $user->setRoles($roles);

        $manager->persist($user);
    }

    public function loadHome(ObjectManager $manager)
    {
        $home1 = new Home();
        $home2 = new Home();
        $home3 = new Home();
        $home4 = new Home();
        $home5 = new Home();

        $home1->setPosition('bandeau');
        $home2->setPosition('porfolio 1');
        $home3->setPosition('porfolio 2');
        $home4->setPosition('porfolio 3');
        $home5->setPosition('porfolio 4');

        $home1->setTitle('bandeau');
        $home2->setTitle('porfolio 1');
        $home3->setTitle('porfolio 2');
        $home4->setTitle('porfolio 3');
        $home5->setTitle('porfolio 4');

        $home1->setTexte('Integer volutpat ante et accumsan commophasellus sed aliquam feugiat lorem aliquet ut enim rutrum phasellus iaculis accumsan dolore magna aliquam veroeros.');
        $home2->setTexte('Integer volutpat ante et accumsan commophasellus sed aliquam feugiat lorem aliquet ut enim rutrum phasellus iaculis accumsan dolore magna aliquam veroeros.');
        $home3->setTexte('Integer volutpat ante et accumsan commophasellus sed aliquam feugiat lorem aliquet ut enim rutrum phasellus iaculis accumsan dolore magna aliquam veroeros.');
        $home4->setTexte('Integer volutpat ante et accumsan commophasellus sed aliquam feugiat lorem aliquet ut enim rutrum phasellus iaculis accumsan dolore magna aliquam veroeros.');
        $home5->setTexte('Integer volutpat ante et accumsan commophasellus sed aliquam feugiat lorem aliquet ut enim rutrum phasellus iaculis accumsan dolore magna aliquam veroeros.');

        $home1->setIcon('bandeau');
        $home2->setIcon('fa-building');
        $home3->setIcon('fa-chart-area');
        $home4->setIcon('fa-cloud');
        $home5->setIcon('fa-lock');

        $manager->persist($home1);
        $manager->persist($home2);
        $manager->persist($home3);
        $manager->persist($home4);
        $manager->persist($home5);


    }
}
