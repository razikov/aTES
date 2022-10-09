<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221008180514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id UUID NOT NULL, email VARCHAR(255) NOT NULL, amount INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE account_operation_log (id UUID NOT NULL, user_id UUID NOT NULL, task_id UUID DEFAULT NULL, type VARCHAR(16) NOT NULL, amount INT NOT NULL, description TEXT NOT NULL, day INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE chronos (id VARCHAR(255) NOT NULL, day INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE email_log (id UUID NOT NULL, message TEXT NOT NULL, sended_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE task (id UUID NOT NULL, description TEXT NOT NULL, penalty INT NOT NULL, reward INT NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE account_operation_log');
        $this->addSql('DROP TABLE chronos');
        $this->addSql('DROP TABLE email_log');
        $this->addSql('DROP TABLE task');
    }
}
