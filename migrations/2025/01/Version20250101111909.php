<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250101111909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE farm_transaction (id SERIAL NOT NULL, related_farm_id INT NOT NULL, external_id VARCHAR(50) NOT NULL, creation_datetime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, direction INT NOT NULL, type INT NOT NULL, amount BIGINT NOT NULL, currency_code VARCHAR(10) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_682F8DB59F75D7B0 ON farm_transaction (external_id)');
        $this->addSql('CREATE INDEX IDX_682F8DB55AE530A8 ON farm_transaction (related_farm_id)');
        $this->addSql('COMMENT ON COLUMN farm_transaction.creation_datetime IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE farm_transaction ADD CONSTRAINT FK_682F8DB55AE530A8 FOREIGN KEY (related_farm_id) REFERENCES farm (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE farm_transaction DROP CONSTRAINT FK_682F8DB55AE530A8');
        $this->addSql('DROP TABLE farm_transaction');
    }
}
