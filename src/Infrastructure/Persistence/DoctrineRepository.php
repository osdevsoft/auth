<?php

namespace Osds\Auth\Infrastructure\Persistence;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Osds\Auth\Domain\User;

class DoctrineRepository
{
    private $entityManager;


    public function __construct()
    {
        $paths = array('../../Domain/');
        $dbParams = array(
            'url' => 'mysql://root:toor@database:3306/nexin_es'
        );

        $isDevMode = false;
        $config = Setup::createConfiguration($isDevMode);
        $driver = new AnnotationDriver(new AnnotationReader(), $paths);

        // registering noop annotation autoloader - allow all annotations by default
        AnnotationRegistry::registerLoader('class_exists');
        $config->setMetadataDriverImpl($driver);

        $entityManager = EntityManager::create($dbParams, $config);

        $this->entityManager = $entityManager;
    }

    public function findBy($entity, $parameters):? User
    {
        return $this->entityManager->getRepository(get_class($entity))->findOneBy($parameters);
    }

}