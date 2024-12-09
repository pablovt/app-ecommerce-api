<?php

namespace App\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;

class DoctrineWriteLoggerSubscriber implements EventSubscriber
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove,
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->logChange('INSERT', $args);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->logChange('UPDATE', $args);
    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        $this->logChange('DELETE', $args);
    }

    private function logChange(string $operation, LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$args->getObjectManager()->getMetadataFactory()->isTransient(get_class($entity))) {
            $this->logger->info(sprintf(
                '%s operation on %s: %s',
                $operation,
                get_class($entity),
                json_encode($entity)
            ));
        }
    }
}
