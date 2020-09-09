<?php


namespace Evrinoma\Delta8Bundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

/**
 * Interface DeltaFixtureInterface
 *
 * @package Evrinoma\Delta8Bundle\Fixtures
 */
interface DeltaFixtureInterface extends FixtureGroupInterface
{
    public function create();
}