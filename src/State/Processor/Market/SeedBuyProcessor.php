<?php

namespace App\State\Processor\Market;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Market\SeedBuy;
use App\Builder\Entity\Farm\FarmSeedBuilder;
use App\Procedure\Transaction\Farm\TransactionProcedure;
use App\Repository\Farm\FarmRepository;
use App\Repository\Seed\SeedRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class SeedBuyProcessor implements ProcessorInterface
{
    public function __construct(
        private SeedRepository $seedRepository,
        private FarmRepository $farmRepository,
        private FarmSeedBuilder $farmSeedBuilder,
        private TransactionProcedure $transactionProcedure,
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @param SeedBuy $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $seed = $this->seedRepository->findOneBy(['externalId' => $data->seed->id]);
        $farm = $this->farmRepository->findOneBy(['name' => $data->farm->name]);
        if (!$seed || !$farm) {
            throw new NotFoundHttpException('Seed or farm not found');
        }

        $farmSeed = $this->farmSeedBuilder->build($farm, $seed, $data->quantity);
        $this->entityManager->persist($farmSeed);
        $transaction = $this->transactionProcedure->createBuySeedProcedure($farm, $seed, $data->quantity);
        $this->entityManager->persist($transaction);
        $this->entityManager->flush();
    }
}