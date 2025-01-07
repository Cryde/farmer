<?php

namespace App\State\Provider\Farm;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Builder\Api\Farm\FarmTransactionBuilder;
use App\Entity\Farm\FarmTransaction;
use App\Repository\Farm\FarmRepository;
use App\Repository\Farm\FarmTransactionRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class FarmTransactionsProvider implements ProviderInterface
{
    public function __construct(
        private FarmRepository            $farmRepository,
        private FarmTransactionRepository $transactionRepository,
        private FarmTransactionBuilder    $transactionBuilder
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (!$farm = $this->farmRepository->findOneBy(['name' => $uriVariables['name']])) {
            throw new NotFoundHttpException('Farm not found');
        }

        // todo pagination
        return array_map(
            fn (FarmTransaction $transaction) => $this->transactionBuilder->build($transaction),
            $this->transactionRepository->findByFarm($farm)
        );
    }
}