<?php

namespace Evrinoma\Delta8Bundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeltaController
 *
 * @package Evrinoma\Delta8Bundle\Controller
 */
final class Delta8Controller extends AbstractController
{
//region SECTION: Public

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @Route("/delta/journal", options={"expose"=true}, name="delta_journal")
     */
    public function deltaJournal()
    {
        $event = ['titleHeader' => 'Delta8 Administration', 'pageName' => 'Journal Delta8'];

        return $this->render('@EvrinomaDelta8/delta8.html.twig', $event);
    }
//endregion Public
}