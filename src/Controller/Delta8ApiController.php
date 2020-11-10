<?php

namespace Evrinoma\Delta8Bundle\Controller;

use Evrinoma\Delta8Bundle\Manager\JournalManagerInterface;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class Delta8ApiController
 *
 * @package Evrinoma\Delta8Bundle\Controller
 */
final class Delta8ApiController extends AbstractApiController
{
//region SECTION: Fields
    /**
     * @var Request
     */
    private $request;
    /**
     * @var JournalManagerInterface
     */
    private $journalManager;
    private $searchManager;
//endregion Fields

//region SECTION: Constructor

    /**
     * ApiController constructor.
     *
     * @param SerializerInterface     $serializer
     * @param RequestStack            $requestStack
     * @param JournalManagerInterface $journalManager
     */
    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        JournalManagerInterface $journalManager
    ) {
        parent::__construct($serializer);
        $this->request        = $requestStack->getCurrentRequest();
        $this->journalManager = $journalManager;
    }
//endregion Constructor

//region SECTION: Public


    /**
     * @Rest\Get("/api/delta8/journal", options={"expose"=true}, name="api_delta_journal")
     * @SWG\Get(tags={"delta"})
     * @SWG\Parameter(
     *      name="dataFlow",
     *      in="query",
     *      type="array",
     *      description="Select data by date value",
     *      items=@SWG\Items(
     *         type="string",
     *         ref=@Model(type=Evrinoma\Delta8Bundle\Form\Rest\DataFlowType::class)
     *     )
     * )
     * @SWG\Parameter(
     *     name="date",
     *     in="query",
     *     type="string",
     *     format="date",
     *     pattern="\d{1,2}-\d{1,2}-\d{4}",
     *     default="13-05-2019",
     *     description="Select data by date value"
     * )
     * @SWG\Response(response=200,description="Returns journal delta")
     */
    public function journalAction()
    {
        $date     = $this->request->get('date');
        $dataFlow = $this->request->get('dataFlow');
        try {
            $data = $this->journalManager->validate($dataFlow, $date)->findParams()->findDiscreetInfo()->getData();
        } catch (\Exception $exception) {
            $data = [];
        }

        return $this->json(['delta_data' => $data]);
    }

    /**
     * @Rest\Get("/api/delta8/object", options={"expose"=true}, name="api_delta_object")
     * @SWG\Get(tags={"delta"})
     * @SWG\Response(response=200,description="Returns delta objects")
     */
    public function journalDelptaObjectAction()
    {
        $settings = $this->journalManager->getSettings();

        return $this->json(
            $this->journalManager->toSelect($settings),
            $this->journalManager->getRestStatus()
        );
    }
//endregion Public
}