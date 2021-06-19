<?php

namespace App\DataFixtures;

use App\Entity\UsersData;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Class UsersDataFixtures.
 */
class UsersDataFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     *                                                     Tworzenie nowego obiektu,
     *                                                     uzupełnienie go danymi
     *                                                     potem rejestracja w menedzerze encji
     *                                                     i na koniec utrwalenie w bazie dancyh
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(120, 'usersData', function($i) {
            $usersData = new UsersData();
            $usersData->setName($this->faker->firstName(null));
            $usersData->setSurname($this->faker->lastName);
            $usersData->setNick($this->faker->userName);
            $usersData->setPhoneNumber($this->faker->phoneNumber);
            $usersData->setBirthDate($this->faker->dateTime('now'));

            $usersData->setAuthor($this->getRandomReference('users'));
            return $usersData;

        });
            $this->manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}

