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


    /**
     * @Route("/delta/rtt", options={"expose"=true}, name="delta_rtt")
     */
    public function deltaJournalRtt()
    {
        $event = ['titleHeader' => 'Delta8 Administration', 'pageName' => 'Rtt Delta8'];

        return $this->render('@EvrinomaDelta8/journal.html.twig', $event);
    }

    /**
     * @Route("/delta/tree", options={"expose"=true}, name="delta_tree")
     */
    public function deltaJournalTree()
    {
        $event = ['titleHeader' => 'Delta8 Administration', 'pageName' => 'Tree Delta8'];

        return $this->render('@EvrinomaDelta8/tree.html.twig', $event);
    }
//endregion Public
}