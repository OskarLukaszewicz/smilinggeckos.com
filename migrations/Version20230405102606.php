<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230405102606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_post_image (blog_post_id INTEGER NOT NULL, image_id INTEGER NOT NULL, PRIMARY KEY(blog_post_id, image_id), CONSTRAINT FK_B4E0AA59A77FBEAF FOREIGN KEY (blog_post_id) REFERENCES blog_post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B4E0AA593DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B4E0AA59A77FBEAF ON blog_post_image (blog_post_id)');
        $this->addSql('CREATE INDEX IDX_B4E0AA593DA5256D ON blog_post_image (image_id)');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, url VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__gecko AS SELECT id, name, sex, price, geck_type, reserved, filename, created_at FROM gecko');
        $this->addSql('DROP TABLE gecko');
        $this->addSql('CREATE TABLE gecko (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, sex VARCHAR(255) DEFAULT NULL, price INTEGER NOT NULL, geck_type INTEGER NOT NULL, reserved BOOLEAN NOT NULL, filename VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO gecko (id, name, sex, price, geck_type, reserved, filename, created_at) SELECT id, name, sex, price, geck_type, reserved, filename, created_at FROM __temp__gecko');
        $this->addSql('DROP TABLE __temp__gecko');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, accepted, message, phone_number, email, created_at, username, uniq_id FROM reservation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, accepted BOOLEAN DEFAULT NULL, message CLOB NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, uniq_id VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO reservation (id, accepted, message, phone_number, email, created_at, username, uniq_id) SELECT id, accepted, message, phone_number, email, created_at, username, uniq_id FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE blog_post_image');
        $this->addSql('DROP TABLE image');
        $this->addSql('ALTER TABLE gecko ADD COLUMN requested_for_reservation BOOLEAN NOT NULL');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, accepted, username, message, phone_number, email, created_at, uniq_id FROM reservation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, accepted BOOLEAN DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, message CLOB NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, uniq_id VARCHAR(255) DEFAULT \'"jax"\' NOT NULL)');
        $this->addSql('INSERT INTO reservation (id, accepted, username, message, phone_number, email, created_at, uniq_id) SELECT id, accepted, username, message, phone_number, email, created_at, uniq_id FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
    }
}
