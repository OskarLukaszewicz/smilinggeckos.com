<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230325144909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__gecko AS SELECT id, name, sex, price, geck_type, reserved, filename FROM gecko');
        $this->addSql('DROP TABLE gecko');
        $this->addSql('CREATE TABLE gecko (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, sex BOOLEAN DEFAULT NULL, price INTEGER NOT NULL, geck_type INTEGER NOT NULL, reserved BOOLEAN NOT NULL, filename VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO gecko (id, name, sex, price, geck_type, reserved, filename) SELECT id, name, sex, price, geck_type, reserved, filename FROM __temp__gecko');
        $this->addSql('DROP TABLE __temp__gecko');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__gecko AS SELECT id, name, sex, price, geck_type, reserved, filename FROM gecko');
        $this->addSql('DROP TABLE gecko');
        $this->addSql('CREATE TABLE gecko (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, reservation_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, sex BOOLEAN DEFAULT NULL, price INTEGER NOT NULL, geck_type INTEGER NOT NULL, reserved BOOLEAN NOT NULL, filename VARCHAR(255) NOT NULL, CONSTRAINT FK_F05DE0ADB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO gecko (id, name, sex, price, geck_type, reserved, filename) SELECT id, name, sex, price, geck_type, reserved, filename FROM __temp__gecko');
        $this->addSql('DROP TABLE __temp__gecko');
        $this->addSql('CREATE INDEX IDX_F05DE0ADB83297E7 ON gecko (reservation_id)');
    }
}
