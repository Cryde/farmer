<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250216101936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE farm_seed (id SERIAL NOT NULL, related_farm_id INT NOT NULL, seed_id INT NOT NULL, quantity INT NOT NULL, creation_datetime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C52CF5235AE530A8 ON farm_seed (related_farm_id)');
        $this->addSql('CREATE INDEX IDX_C52CF52364430F6A ON farm_seed (seed_id)');
        $this->addSql('ALTER TABLE farm_seed ADD CONSTRAINT FK_C52CF5235AE530A8 FOREIGN KEY (related_farm_id) REFERENCES farm (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE farm_seed ADD CONSTRAINT FK_C52CF52364430F6A FOREIGN KEY (seed_id) REFERENCES seed (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE farm_seed DROP CONSTRAINT FK_C52CF5235AE530A8');
        $this->addSql('ALTER TABLE farm_seed DROP CONSTRAINT FK_C52CF52364430F6A');
        $this->addSql('DROP TABLE farm_seed');
    }
}
