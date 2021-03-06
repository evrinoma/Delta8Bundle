<?php

namespace Evrinoma\Delta8Bundle\Fixtures;


use Evrinoma\SettingsBundle\Std\DescriptionStd;
use Evrinoma\SettingsBundle\Std\ServerStd;
use Evrinoma\SettingsBundle\Dto\ServiceDto;
use Evrinoma\SettingsBundle\Entity\Settings;

/**
 * Class DeltaFixtures
 *
 * @package Evrinoma\Delta8Bundle\Fixtures\DataFixtures
 */
class DeltaFixtures extends AbstractDeltaFixtures
{

//region SECTION: Public
    /**
     * 
     */
    public function create()
    {
        $descriptionChild = new DescriptionStd();
        $descriptionChild
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('TAZOVSKIY_DATA')
            ->setDate((new \DateTime())->createFromFormat('dmY', '17112017'));

        $description= new DescriptionStd();
        $description
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('TAZOVSKIY')
            ->addChild($descriptionChild);

        $service = new ServerStd();
        $service
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType('orm')
            ->setDescription($description)
            ->setRemote();

        $settings = new Settings();
        $settings->setData($service)->setType(ServiceDto::class);
        $this->objectManager->persist($settings);

        $descriptionChild = new DescriptionStd();
        $descriptionChild
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('BELOYARSK_DATA')
            ->setDate((new \DateTime())->createFromFormat('dmY', '25032019'));

        $description= new DescriptionStd();
        $description
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('BELOYARSK')
            ->addChild($descriptionChild);

        $service = new ServerStd();
        $service
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType('orm')
            ->setDescription($description)
            ->setRemote();

        $settings = new Settings();
        $settings->setData($service)->setType(ServiceDto::class);
        $this->objectManager->persist($settings);

        $descriptionChild = new DescriptionStd();
        $descriptionChild
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('KAMENNIY_GPA_DATA')
            ->setDate((new \DateTime())->createFromFormat('dmY', '18032017'));

        $description= new DescriptionStd();
        $description
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('KAMENNIY_GPA')
            ->addChild($descriptionChild);

        $service = new ServerStd();
        $service
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType('orm')
            ->setDescription($description)
            ->setRemote();

        $settings = new Settings();
        $settings->setData($service)->setType(ServiceDto::class);
        $this->objectManager->persist($settings);

        $descriptionChild = new DescriptionStd();
        $descriptionChild
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('TG6_DATA')
            ->setDate((new \DateTime())->createFromFormat('dmY', '15042019'));

        $description= new DescriptionStd();
        $description
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('TG6')
            ->addChild($descriptionChild);

        $service = new ServerStd();
        $service
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType('orm')
            ->setDescription($description)
            ->setRemote();

        $settings = new Settings();
        $settings->setData($service)->setType(ServiceDto::class);
        $this->objectManager->persist($settings);

        $descriptionChild = new DescriptionStd();
        $descriptionChild
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('TG8_DATA')
            ->setDate((new \DateTime())->createFromFormat('dmY', '22032018'));

        $description= new DescriptionStd();
        $description
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('TG8')
            ->addChild($descriptionChild);

        $service = new ServerStd();
        $service
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType('orm')
            ->setDescription($description)
            ->setRemote();

        $settings = new Settings();
        $settings->setData($service)->setType(ServiceDto::class);
        $this->objectManager->persist($settings);

        $descriptionChild = new DescriptionStd();
        $descriptionChild
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('YARSALE_DATA')
            ->setDate((new \DateTime())->createFromFormat('dmY', '01032020'));


        $description= new DescriptionStd();
        $description
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('YARSALE')
            ->addChild($descriptionChild);

        $service = new ServerStd();
        $service
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType('orm')
            ->setDescription($description)
            ->setRemote();

        $settings = new Settings();
        $settings->setData($service)->setType(ServiceDto::class);
        $this->objectManager->persist($settings);

        $descriptionChild = new DescriptionStd();
        $descriptionChild
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('KRASNOSELKUP_DATA')
            ->setDate((new \DateTime())->createFromFormat('dmY', '08092020'));


        $description= new DescriptionStd();
        $description
            ->setName('MsSql')
            ->setInstance('DCSRV01')
            ->setDescription('KRASNOSELKUP')
            ->addChild($descriptionChild);

        $service = new ServerStd();
        $service
            ->setPort('1433')
            ->setHost('172.16.45.10')
            ->setType('orm')
            ->setDescription($description)
            ->setRemote();

        $settings = new Settings();
        $settings->setData($service)->setType(ServiceDto::class);
        $this->objectManager->persist($settings);

        $this->objectManager->flush();
    }
//endregion Public
    public static function getGroups(): array
    {
        return ['DeltaFixtures', 'SearchSettingsFixtures'];
    }
}