<?php

namespace Evrinoma\Delta8Bundle\Manager;


use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\Delta8Bundle\Entity\DiscreetInfo;
use Evrinoma\Delta8Bundle\Entity\Params;
use Evrinoma\SettingsBundle\Dto\ApartDto\ServerDto;
use Evrinoma\SettingsBundle\Dto\ServiceDto;
use Evrinoma\SettingsBundle\Entity\Settings;
use Evrinoma\SettingsBundle\Manager\SettingsManagerInterface;
use Evrinoma\UtilsBundle\Manager\AbstractEntityManager;
use Evrinoma\UtilsBundle\Rest\RestTrait;

/**
 * Class JournalManager
 *
 * @package Evrinoma\Delta8Bundle\Manager
 */
class JournalManager extends AbstractEntityManager implements JournalManagerInterface
{
    use RestTrait;

//region SECTION: Fields
    const MSSQL_LINK    = 'delta';
    const DEFAULT_LIMIT = 500;

    /** @var Params[] */
    private $params = [];

    /** @var Params[] */
    private $paramsHasDiscretInfo = [];

    /** @var DiscreetInfo[] */
    private $discretInfo = [];

    private $entityManagerDelta;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var SettingsManagerInterface
     */
    private $settingsManager;

    /**
     * @var \DateTime
     */
    private $date;

    private $dto;
//endregion Fields


//region SECTION: Constructor
    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $registry, SettingsManagerInterface $settingsManager)
    {
        parent::__construct($entityManager);

        $this->entityManagerDelta = $registry->getManager('delta8');
        $this->connection         = $this->entityManagerDelta->getConnection();

        $this->settingsManager = $settingsManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param $dataFlow
     * @param $date
     *
     * @return $this
     */
    public function validate($dataFlow, $date): JournalManagerInterface
    {
        $dto = $this->getDto();
        $dto->setServer($this->getSettingsByDescription($dataFlow))->setDate($date);

        if ($dto->isValid()) {
            $this->dto = $dto;
        } else {
            $this->setRestClientErrorBadRequest();
        }

        return $this;
    }

    public function toSelect(array $settings)
    {
        $select = [];
        /** @var ServerDto $setting */
        foreach ($settings as $setting) {
            $select[] = $setting->getDescription()->getDescription();
        }

        return $select;
    }
//endregion Public

//region SECTION: Private
    private function toTableName()
    {
        return 'D'.$this->dto->getDate()->format('dmY');
    }

    private function connectionSwitcher($dbName)
    {
        $params           = $this->connection->getParams();
        $params['dbname'] = $dbName;
        if ($this->connection->isConnected()) {
            $this->connection->close();
        }

        $this->connection->__construct(
            $params,
            $this->connection->getDriver(),
            $this->connection->getConfiguration(),
            $this->connection->getEventManager()
        );
        try {
            $this->connection->connect();
        } catch (\Exception $e) {
            // log and handle exception
        }
    }

    /**
     * @return $this
     */
    private function getDiscretInfo()
    {
        $this->connectionSwitcher($this->dto->getServer()->getDescription()->getChildFirst()->getDescription());

        $metadata = $this->entityManagerDelta->getClassMetadata(DiscreetInfo::class);
        $metadata->setPrimaryTable(['name' => $this->toTableName()]);
        /** @var EntityRepository $repository */
        $repository = $this->entityManagerDelta->getRepository(DiscreetInfo::class);
        $this->dto->addDiscreetInfo($repository->findBy([], ['n' => 'ASC'], self::DEFAULT_LIMIT));

        return $this;
    }
//endregion Private

//region SECTION: Dto
    private function getDto()
    {
        return new class() {
            /** @var Params[] */
            private $params = [];

            /** @var Params[] */
            private $hasDiscreetInfo = [];

            /** @var DiscreetInfo[] */
            private $discreetInfo = [];
            /**
             * @var ServerDto
             */
            private $server;
            /**
             * @var \DateTime
             */
            private $date;

            /**
             * @return Params[]
             */
            public function getParams(): array
            {
                return $this->params;
            }

            /**
             * @param Params[] $params
             *
             * @return $this
             */
            public function setParams($params): self
            {
                $this->params = $params;

                return $this;
            }

            /**
             * @param Params $param
             *
             * @return $this
             */
            public function addParam($param): self
            {
                $this->params[$param->getId()] = $param;

                return $this;
            }

            /**
             * @return Params[]
             */
            public function getHasDiscreetInfo(): array
            {
                return $this->hasDiscreetInfo;
            }

            /**
             * @param Params[] $hasDiscreetInfo
             *
             * @return $this
             */
            public function setHasDiscreetInfo($hasDiscreetInfo): self
            {
                $this->hasDiscreetInfo = $hasDiscreetInfo;

                return $this;
            }

            /**
             * @return DiscreetInfo[]
             */
            public function getDiscreetInfo(): array
            {
                return $this->discreetInfo;
            }

            /**
             * @param DiscreetInfo[] $discreetInfo
             *
             * @return $this
             */
            public function setDiscreetInfo($discreetInfo): self
            {
                $this->discreetInfo = $discreetInfo;

                return $this;
            }

            /**
             * @param DiscreetInfo[] $discreetInfo
             *
             * @return $this
             */
            public function addDiscreetInfo($discreetInfo): self
            {
                $this->setDiscreetInfo($discreetInfo);

                /** @var DiscreetInfo $item */
                foreach ($this->discreetInfo as $item) {
                    $param = &$this->params[$item->getN()];
                    if ($param) {
                        if ($item->getV()) {
                            $param
                                ->addDiscreetInfo($item)
                                ->setInitial();
                            $this->hasDiscreetInfo[] = &$param;
                        } elseif ($this->params[$item->getN()]->getInitial()) {
                            $discreetInfo = $param->getLastDiscreetInfo();
                            $discreetInfo->setTe($item->getT());
                            $param->setInitial();
                        }
                    }
                }

                return $this;
            }

            /**
             * @return ServerDto
             */
            public function getServer(): ServerDto
            {
                return $this->server;
            }

            /**
             * @param ServerDto $server
             *
             * @return $this
             */
            public function setServer(ServerDto $server): self
            {
                $this->server = $server;

                return $this;
            }

            /**
             * @return \DateTime
             */
            public function getDate(): \DateTime
            {
                return $this->date;
            }

            /**
             * @param string $date
             *
             * @return $this
             */
            public function setDate(string $date): self
            {
                $this->date = (new \DateTime())->createFromFormat('d-m-Y', $date);

                return $this;
            }

            /**
             * @return bool
             */
            public function isValid(): bool
            {
                return ($this->getServer()
                    && $this->getServer()->getDescription()
                    && $this->getServer()->getDescription()->getChildFirst()
                    && $this->getServer()->getDescription()->getChildFirst()->leDate($this->getDate()));
            }

        };
    }
//endregion SECTION: Dto

//region SECTION: Find Filters Repository
    /**
     * @return $this
     */
    public function findParams(): JournalManagerInterface
    {
        if ($this->dto) {
            /** @var Params $item */
            $this->connectionSwitcher($this->dto->getServer()->getDescription()->getDescription());
            $repository = $this->entityManagerDelta->getRepository(Params::class);
            foreach ($repository->findAll() as $item) {
                $this->dto->addParam($item);
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function findDiscreetInfo(): JournalManagerInterface
    {
        if ($this->dto) {
            $this->getDiscretInfo();
        }

        return $this;
    }
//endregion Find Filters Repository

//region SECTION: Getters/Setters
    /**
     * @return mixed
     */
    public function getData()
    {
        return ($this->dto) ? $this->dto->getHasDiscreetInfo() : [];
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }

    /**
     * @return ServerDto[]
     */
    public function getSettings()
    {
        $settings = [];
        /** @var Settings $server */
        foreach ($this->settingsManager->toSettings(new ServiceDto()) as $server) {
            /** @var ServerDto $setting */
            $setting = $server->getData();
            if ('orm' === $setting->getType() && $setting->getDescription() && $setting->getDescription()->getName() === 'MsSql') {
                $settings[] = $setting;
            }
        }

        return $settings;
    }

    /**
     * @param $description
     */
    public function getSettingsByDescription($description)
    {
        $settings = $this->getSettings();
        /** @var  $setting */
        foreach ($settings as $setting) {
            if ($setting->getDescription()->getDescription() === $description) {
                return $setting;
            }
        }

        return null;
    }
//endregion Getters/Setters
}