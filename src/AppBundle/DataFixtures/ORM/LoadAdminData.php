<?php
namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;

/*
 * Loading of Admin role user into DB
 */
class LoadAdminData implements FixtureInterface, ContainerAwareInterface{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container=$container;
    }

    /**
     * load function for Fixture
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $userAdmin = $userManager->createUser();
        $userAdmin->setUsername('admin1');
        $userAdmin->setPlainPassword('rtynzhf');
        $userAdmin->setEmail('testmail@mail.com');
        $userAdmin->setEnabled(true);
        $userAdmin->setRoles(array('ROLE_ADMIN'));
        $userManager->updateUser($userAdmin,true);
    }
}