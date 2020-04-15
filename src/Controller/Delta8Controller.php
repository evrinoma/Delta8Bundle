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
     * @Route("/delta/ag_simple", options={"expose"=true}, name="delta_ag_simple")
     */
    public function deltaAgSimple()
    {
        $event = ['titleHeader' => 'Delta8 Administration', 'pageName' => 'Ag Simple Delta8'];

        return $this->render('@EvrinomaDelta8/ag_simple.html.twig', $event);
    }

    /**
     * @Route("/delta/ag_tree", options={"expose"=true}, name="delta_ag_tree")
     */
    public function deltaAgTree()
    {
        $event = ['titleHeader' => 'Delta8 Administration', 'pageName' => 'AgTree Delta8'];

        return $this->render('@EvrinomaDelta8/ag_tree.html.twig', $event);
    }

    /**
     * @Route("/delta/handson_tree", options={"expose"=true}, name="delta_handson_tree")
     */
    public function deltaHandsonTree()
    {
        $event = ['titleHeader' => 'Delta8 Administration', 'pageName' => 'Handson Delta8'];

        return $this->render('@EvrinomaDelta8/handson_tree.html.twig', $event);
    }
//endregion Public
}