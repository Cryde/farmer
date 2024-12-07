<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241201094901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE access_token (id SERIAL NOT NULL, related_farmer_id INT NOT NULL, creation_datetime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, token VARCHAR(255) NOT NULL, expiration_datetime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, last_usage_datetime TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6A2DD68BB894130 ON access_token (related_farmer_id)');
        $this->addSql('CREATE TABLE farmer (id SERIAL NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, creation_datetime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, public_account_id VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON farmer (username)');
        $this->addSql('ALTER TABLE access_token ADD CONSTRAINT FK_B6A2DD68BB894130 FOREIGN KEY (related_farmer_id) REFERENCES farmer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE access_token DROP CONSTRAINT FK_B6A2DD68BB894130');
        $this->addSql('DROP TABLE access_token');
        $this->addSql('DROP TABLE farmer');
    }
}
