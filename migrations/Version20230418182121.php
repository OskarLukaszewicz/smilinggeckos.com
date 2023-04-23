<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230418182121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation ADD COLUMN note CLOB DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, accepted, username, message, phone_number, email, created_at, uniq_id, already_seen FROM reservation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, accepted BOOLEAN DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, message CLOB NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, uniq_id VARCHAR(255) NOT NULL, already_seen BOOLEAN DEFAULT 0 NOT NULL)');
        $this->addSql('INSERT INTO reservation (id, accepted, username, message, phone_number, email, created_at, uniq_id, already_seen) SELECT id, accepted, username, message, phone_number, email, created_at, uniq_id, already_seen FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
    }
}
