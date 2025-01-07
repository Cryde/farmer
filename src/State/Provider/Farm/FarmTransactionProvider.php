<?php

namespace App\State\Provider\Farm;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Builder\Api\Farm\FarmTransactionBuilder;
use App\Repository\Farm\FarmTransactionRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class FarmTransactionProvider implements ProviderInterface
{
    public function __construct(
        private FarmTransactionRepository $transactionRepository,
        private FarmTransactionBuilder    $transactionBuilder
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (!$transaction = $this->transactionRepository->findOneBy(['externalId' => $uriVariables['id']])) {
            throw new NotFoundHttpException('Transaction not found');
        }

        return $this->transactionBuilder->build($transaction);
    }
}