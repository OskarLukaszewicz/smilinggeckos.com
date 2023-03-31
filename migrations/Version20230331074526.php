<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331074526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__gecko AS SELECT id, name, sex, price, geck_type, reserved, filename, created_at, requested_for_reservation FROM gecko');
        $this->addSql('DROP TABLE gecko');
        $this->addSql('CREATE TABLE gecko (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, sex VARCHAR(255) DEFAULT NULL, price INTEGER NOT NULL, geck_type INTEGER NOT NULL, reserved BOOLEAN NOT NULL, filename VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, requested_for_reservation BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO gecko (id, name, sex, price, geck_type, reserved, filename, created_at, requested_for_reservation) SELECT id, name, sex, price, geck_type, reserved, filename, created_at, requested_for_reservation FROM __temp__gecko');
        $this->addSql('DROP TABLE __temp__gecko');
        $this->addSql('ALTER TABLE reservation ADD COLUMN declined BOOLEAN NOT NULL DEFAULT FALSE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__gecko AS SELECT id, name, sex, price, geck_type, reserved, requested_for_reservation, filename, created_at FROM gecko');
        $this->addSql('DROP TABLE gecko');
        $this->addSql('CREATE TABLE gecko (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, sex VARCHAR(255) DEFAULT NULL, price INTEGER NOT NULL, geck_type INTEGER NOT NULL, reserved BOOLEAN NOT NULL, requested_for_reservation BOOLEAN DEFAULT FALSE NOT NULL, filename VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO gecko (id, name, sex, price, geck_type, reserved, requested_for_reservation, filename, created_at) SELECT id, name, sex, price, geck_type, reserved, requested_for_reservation, filename, created_at FROM __temp__gecko');
        $this->addSql('DROP TABLE __temp__gecko');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, accepted, message, phone_number, email, created_at FROM reservation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, accepted BOOLEAN NOT NULL, message CLOB NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO reservation (id, accepted, message, phone_number, email, created_at) SELECT id, accepted, message, phone_number, email, created_at FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
    }
}
