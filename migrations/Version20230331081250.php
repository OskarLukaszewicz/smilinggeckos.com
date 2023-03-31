<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331081250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, accepted, message, phone_number, email, created_at FROM reservation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, accepted BOOLEAN DEFAULT NULL, message CLOB NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO reservation (id, accepted, message, phone_number, email, created_at) SELECT id, accepted, message, phone_number, email, created_at FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, accepted, message, phone_number, email, created_at FROM reservation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, accepted BOOLEAN NOT NULL, message CLOB NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, declined BOOLEAN DEFAULT FALSE NOT NULL)');
        $this->addSql('INSERT INTO reservation (id, accepted, message, phone_number, email, created_at) SELECT id, accepted, message, phone_number, email, created_at FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
    }
}
