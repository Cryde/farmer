<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241222170330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE extension (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, type VARCHAR(255) NOT NULL, is_updatable BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_NAME ON extension (type)');
        $this->addSql('CREATE TABLE farm (id SERIAL NOT NULL, related_farmer_id INT NOT NULL, name VARCHAR(255) NOT NULL, creation_datetime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5816D045BB894130 ON farm (related_farmer_id)');
        $this->addSql('CREATE TABLE farm_extension (id SERIAL NOT NULL, farm_id INT NOT NULL, extension_id INT NOT NULL, external_id VARCHAR(255) NOT NULL, creation_datetime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, level SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_14518ECB65FCFA0D ON farm_extension (farm_id)');
        $this->addSql('CREATE INDEX IDX_14518ECB812D5EB ON farm_extension (extension_id)');
        $this->addSql('ALTER TABLE farm ADD CONSTRAINT FK_5816D045BB894130 FOREIGN KEY (related_farmer_id) REFERENCES farmer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE farm_extension ADD CONSTRAINT FK_14518ECB65FCFA0D FOREIGN KEY (farm_id) REFERENCES farm (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE farm_extension ADD CONSTRAINT FK_14518ECB812D5EB FOREIGN KEY (extension_id) REFERENCES extension (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE farm DROP CONSTRAINT FK_5816D045BB894130');
        $this->addSql('ALTER TABLE farm_extension DROP CONSTRAINT FK_14518ECB65FCFA0D');
        $this->addSql('ALTER TABLE farm_extension DROP CONSTRAINT FK_14518ECB812D5EB');
        $this->addSql('DROP TABLE extension');
        $this->addSql('DROP TABLE farm');
        $this->addSql('DROP TABLE farm_extension');
    }
}
