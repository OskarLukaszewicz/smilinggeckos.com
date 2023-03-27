<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230326151640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TEMPORARY TABLE __temp__blog_post AS SELECT id, author_id, title, published, content, slug FROM blog_post');
        $this->addSql('DROP TABLE blog_post');
        $this->addSql('CREATE TABLE blog_post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, content CLOB NOT NULL, slug VARCHAR(255) NOT NULL, CONSTRAINT FK_BA5AE01DF675F31B FOREIGN KEY (author_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO blog_post (id, author_id, title, created_at, content, slug) SELECT id, author_id, title, published, content, slug FROM __temp__blog_post');
        $this->addSql('DROP TABLE __temp__blog_post');
        $this->addSql('CREATE INDEX IDX_BA5AE01DF675F31B ON blog_post (author_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, blog_post_id, content, author_name, published FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, blog_post_id INTEGER NOT NULL, content VARCHAR(255) NOT NULL, author_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, CONSTRAINT FK_9474526CA77FBEAF FOREIGN KEY (blog_post_id) REFERENCES blog_post (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, blog_post_id, content, author_name, created_at) SELECT id, blog_post_id, content, author_name, published FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CA77FBEAF ON comment (blog_post_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, accepted, message, phone_number, email, reservation_date FROM reservation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, accepted BOOLEAN NOT NULL, message CLOB NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO reservation (id, accepted, message, phone_number, email, created_at) SELECT id, accepted, message, phone_number, email, reservation_date FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, url VARCHAR(255) DEFAULT NULL COLLATE "BINARY")');
        $this->addSql('CREATE TEMPORARY TABLE __temp__blog_post AS SELECT id, author_id, title, created_at, content, slug FROM blog_post');
        $this->addSql('DROP TABLE blog_post');
        $this->addSql('CREATE TABLE blog_post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, published DATETIME NOT NULL, content CLOB NOT NULL, slug VARCHAR(255) NOT NULL, CONSTRAINT FK_BA5AE01DF675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO blog_post (id, author_id, title, published, content, slug) SELECT id, author_id, title, created_at, content, slug FROM __temp__blog_post');
        $this->addSql('DROP TABLE __temp__blog_post');
        $this->addSql('CREATE INDEX IDX_BA5AE01DF675F31B ON blog_post (author_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, blog_post_id, content, author_name, created_at FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, blog_post_id INTEGER NOT NULL, content VARCHAR(255) NOT NULL, author_name VARCHAR(255) NOT NULL, published DATETIME NOT NULL, CONSTRAINT FK_9474526CA77FBEAF FOREIGN KEY (blog_post_id) REFERENCES blog_post (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, blog_post_id, content, author_name, published) SELECT id, blog_post_id, content, author_name, created_at FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CA77FBEAF ON comment (blog_post_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, accepted, message, phone_number, email, created_at FROM reservation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, accepted BOOLEAN NOT NULL, message CLOB NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, reservation_date DATETIME NOT NULL)');
        $this->addSql('INSERT INTO reservation (id, accepted, message, phone_number, email, reservation_date) SELECT id, accepted, message, phone_number, email, created_at FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
    }
}
