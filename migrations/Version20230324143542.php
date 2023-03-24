<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230324143542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, published DATETIME NOT NULL, content CLOB NOT NULL, slug VARCHAR(255) NOT NULL, CONSTRAINT FK_BA5AE01DF675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BA5AE01DF675F31B ON blog_post (author_id)');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, post_id INTEGER NOT NULL, content VARCHAR(255) NOT NULL, published DATETIME NOT NULL, CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES blog_post (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)');
        $this->addSql('CREATE INDEX IDX_9474526C4B89032C ON comment (post_id)');
        $this->addSql('CREATE TABLE gecko (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, reservation_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, sex BOOLEAN DEFAULT NULL, price INTEGER NOT NULL, geck_type INTEGER NOT NULL, reserved BOOLEAN NOT NULL, filename VARCHAR(255) NOT NULL, CONSTRAINT FK_F05DE0ADB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F05DE0ADB83297E7 ON gecko (reservation_id)');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, accepted BOOLEAN NOT NULL, message CLOB NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, reservation_date DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:simple_array)
        )');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE blog_post');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE gecko');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE user');
    }
}
