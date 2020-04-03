<?php


namespace Evrinoma\Delta8Bundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Evrinoma\Delta8Bundle\DependencyInjection\EvrinomaDelta8BundleExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvrinomaDelta8Bundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $managerParameters[] = 'delta8';
        $ormCompilerClass = 'Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass';
        if (class_exists($ormCompilerClass)) {
            $container->addCompilerPass(
                DoctrineOrmMappingsPass::createAnnotationMappingDriver(
                    ['Evrinoma\EximBundle\Entity'],
                    [sprintf('%s/Entity', $this->getPath())],
                    $managerParameters
                )
            );
        }
    }

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaDelta8BundleExtension();
        }
        return $this->extension;
    }
}