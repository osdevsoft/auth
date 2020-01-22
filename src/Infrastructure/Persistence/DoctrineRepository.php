<?php

namespace Osds\Auth\Infrastructure\Persistence;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Osds\Auth\Domain\User;

class DoctrineRepository
{
    private $entityManager;


    public function __construct()
    {
        $paths = array('../../Domain/');

        $config = Setup::createAnnotationMetadataConfiguration($paths);
        $dbParams = array(
            'url' => DATABASE_URL
        );
        $entityManager = EntityManager::create($dbParams, $config);

        $this->entityManager = $entityManager;
    }

    public function findBy($entity, $parameters): User
    {
        return $this->entityManager->getRepository($entity)->findOneBy($parameters);
    }

}