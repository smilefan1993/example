<?php
namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/*
 * Loading of Admin role user into DB
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
{

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


    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        for($i=0;$i<=10;++$i) {
            $user = $userManager->createUser();
            $user->setUsername('user'.$i);
            $user->setPlainPassword('rtynzhf');
            $user->setEmail('testmail'.$i.'@mail.com');
            $user->setEnabled(true);
            $userManager->updateUser($user, true);
        }
    }
    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }
}