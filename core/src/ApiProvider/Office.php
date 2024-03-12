<?php

namespace App\ApiProvider;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Mandate;
use App\Repository\MandateRepository;

/**
 * @implements ProviderInterface<Mandate[]|Mandate|null>
 */
final class Office implements ProviderInterface
{

    private MandateRepository $mandateRepository;

    public function __construct(MandateRepository $mandateRepository)
    {
        $this->mandateRepository = $mandateRepository;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            return $this->mandateRepository->findCurrents();
        } else {
            return null;
        }
    }


}