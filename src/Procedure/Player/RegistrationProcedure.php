<?php

namespace App\Procedure\Player;

use App\ApiResource\Player\Register;
use App\Builder\Api\Player\RegisterBuilder;
use App\Builder\Entity\Farm\FarmEntityBuilder;
use App\Builder\Entity\Farm\FarmExtensionEntityBuilder;
use App\Builder\Entity\Farmer\FarmerEntityBuilder;
use App\Builder\Entity\Security\AccessTokenBuilder;
use App\Contract\Generator\AccessTokenGeneratorInterface;
use App\Contract\Generator\ShortIdGeneratorInterface;
use App\Entity\Farm\Farm;
use App\Enum\Extension\ExtensionType;
use App\Model\Api\Register\Register as RegisterApi;
use App\Procedure\Transaction\Farm\TransactionProcedure;
use App\Repository\Extension\ExtensionRepository;
use App\Service\Generator\FarmNameGenerator;
use Doctrine\ORM\EntityManagerInterface;

readonly class RegistrationProcedure
{
    public function __construct(
        private AccessTokenGeneratorInterface $accessTokenGenerator,
        private FarmerEntityBuilder    $farmerEntityBuilder,
        private AccessTokenBuilder     $accessTokenBuilder,
        private EntityManagerInterface $entityManager,
        private RegisterBuilder        $registerBuilder,
        private FarmEntityBuilder $farmEntityBuilder,
        private FarmNameGenerator $farmNameGenerator,
        private ExtensionRepository $extensionRepository,
        private FarmExtensionEntityBuilder $farmExtensionEntityBuilder,
        private ShortIdGeneratorInterface $shortIdGenerator,
        private TransactionProcedure $transactionProcedure

    ) {
    }

    public function register(Register $registerModel): RegisterApi
    {
        // farmer
        $farmer = $this->farmerEntityBuilder->build(mb_strtoupper($registerModel->username));
        $this->entityManager->persist($farmer);

        // access token
        $token = $this->accessTokenGenerator->generate();
        $accessToken = $this->accessTokenBuilder->build($farmer, $token, new \DateTime('+ 2 months')); // todo set expiration related to a reset world
        $this->entityManager->persist($accessToken);

        // farm
        $farm = $this->farmEntityBuilder->build($farmer, $this->farmNameGenerator->generateFarmName($registerModel->username));
        $this->entityManager->persist($farm);

        // farm extensions
        $this->addBasicFarmExtension($farm);

        // farm transactions
        $initialTransaction = $this->transactionProcedure->createInitialTransaction($farm, '100000');
        $this->entityManager->persist($initialTransaction);

        $this->entityManager->flush();

        return $this->registerBuilder->build($farmer, $token);
    }


    private function addBasicFarmExtension(Farm $farm): void
    {
        foreach (ExtensionType::basicExtension() as $extensionEnum) {
            if ($extension = $this->extensionRepository->findOneBy(['type' => $extensionEnum])) {
                $farmExtension = $this->farmExtensionEntityBuilder->build(
                    $farm,
                    $extension,
                    1,
                    $this->shortIdGenerator->generateShortId()
                );
                $this->entityManager->persist($farmExtension);
            }
        }
    }
}