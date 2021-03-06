<?php


namespace Evrinoma\Delta8Bundle\Menu;


use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\Delta8Bundle\Voter\Delta8RoleInterface;
use Evrinoma\MenuBundle\Entity\MenuItem;
use Evrinoma\MenuBundle\Menu\MenuInterface;

/**
 * Class Delta8Menu
 *
 * @package Evrinoma\Delta8Bundle\Menu
 */
final class Delta8Menu implements MenuInterface
{

    public function create(EntityManagerInterface $em): void
    {
        $journal = new MenuItem();
        $journal
            ->setRole([Delta8RoleInterface::ROLE_USER_DELTA8])
            ->setName('Journal')
            ->setRoute('delta_journal')
            ->setTag($this->tag());

        $em->persist($journal);

        $menuDelta = new MenuItem();
        $menuDelta
            ->setRole([Delta8RoleInterface::ROLE_USER_DELTA8])
            ->setName('Delta8')
            ->setUri('#')
            ->addChild($journal)
            ->setTag($this->tag());

        $em->persist($menuDelta);
    }

    public function order(): int
    {
        return 5;
    }

    public function tag(): string
    {
        return MenuInterface::DEFAULT_TAG;
    }
}