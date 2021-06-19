<?php
/**
 * Event Fixtures.
 */
namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
/**
 * Class EventFixtures.
 */
class EventFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(120, 'events', function($i) {
            $event = new Event();
            $event->setTitle($this->faker->sentence);
            $event->setDescription($this->faker->sentence);
            $event->setDate($this->faker->dateTimeBetween('-1 days', '100 days'));
            $event->setCategory($this->getRandomReference('categories'));

            $tags = $this->getRandomReferences(
                'tags',
                $this->faker->numberBetween(0, 5)
            );

            foreach($tags as $tag){
                $event->addTag($tag);
            }

            $event->setAuthor($this->getRandomReference('users'));

            return $event;
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
        return [CategoryFixtures::class, TagFixtures::class, UserFixtures::class];
    }
}