<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406142635 extends AbstractMigration
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
        $this->addSql('CREATE TABLE gecko (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, sex VARCHAR(255) DEFAULT NULL, price INTEGER NOT NULL, geck_type INTEGER NOT NULL, reserved BOOLEAN NOT NULL, filename VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, requested_for_reservation BOOLEAN DEFAULT 0)');
        $this->addSql('INSERT INTO gecko (id, name, sex, price, geck_type, reserved, filename, created_at, requested_for_reservation) SELECT id, name, sex, price, geck_type, reserved, filename, created_at, requested_for_reservation FROM __temp__gecko');
        $this->addSql('DROP TABLE __temp__gecko');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__gecko AS SELECT id, name, sex, price, geck_type, reserved, filename, created_at, requested_for_reservation FROM gecko');
        $this->addSql('DROP TABLE gecko');
        $this->addSql('CREATE TABLE gecko (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, sex VARCHAR(255) DEFAULT NULL, price INTEGER NOT NULL, geck_type INTEGER NOT NULL, reserved BOOLEAN NOT NULL, filename VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, requested_for_reservation BOOLEAN DEFAULT 0 NOT NULL)');
        $this->addSql('INSERT INTO gecko (id, name, sex, price, geck_type, reserved, filename, created_at, requested_for_reservation) SELECT id, name, sex, price, geck_type, reserved, filename, created_at, requested_for_reservation FROM __temp__gecko');
        $this->addSql('DROP TABLE __temp__gecko');
    }
}
