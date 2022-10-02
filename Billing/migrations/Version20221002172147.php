<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221002172147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE account_operation_log_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE account (user_id VARCHAR(255) NOT NULL, amount INT NOT NULL, PRIMARY KEY(user_id))');
        $this->addSql('CREATE TABLE account_operation_log (id VARCHAR(255) NOT NULL, user_id VARCHAR(255) NOT NULL, type VARCHAR(16) NOT NULL, amount INT NOT NULL, description TEXT NOT NULL, day INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE chronos (id VARCHAR(255) NOT NULL, day INT NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE account_operation_log_id_seq CASCADE');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE account_operation_log');
        $this->addSql('DROP TABLE chronos');
    }
}
