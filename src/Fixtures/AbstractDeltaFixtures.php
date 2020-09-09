<?php


namespace Evrinoma\Delta8Bundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class AbstractDeltaFixtures
 *
 * @package Evrinoma\Delta8Bundle\Fixtures
 */
abstract class AbstractDeltaFixtures extends Fixture implements DeltaFixtureInterface
{
//region SECTION: Fields
    /**
     * @var ObjectManager
     */
    protected $objectManager;
//endregion Fields

//region SECTION: Public
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->objectManager = $manager;

        $this->create();

        $this->objectManager->flush();
    }
}