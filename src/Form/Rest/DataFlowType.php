<?php

namespace Evrinoma\Delta8Bundle\Form\Rest;

use Evrinoma\Delta8Bundle\Manager\JournalManager;
use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DataFlowType
 *
 * @package App\Form\Delta
 */
class DataFlowType extends AbstractType
{
    //region SECTION: Fields
    /**
     * JournalManager.
     */
    private $journalManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * ServerType constructor.
     */
    public function __construct(JournalManager $journalManager)
    {
        $this->journalManager = $journalManager;
    }

//endregion Constructor
//region SECTION: Public
    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $settings = $this->journalManager->getSettings();

            return $this->journalManager->toSelect($settings);
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'dataflow');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'Delta Data Server');
        $resolver->setDefault(RestChoiceType::REST_CHOICES, $callback);
    }
//endregion Public
//endregion Public

//region SECTION: Getters/Setters
    public function getParent()
    {
        return RestChoiceType::class;
    }
//endregion Getters/Setters
}