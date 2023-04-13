<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406180521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reserved_geckos');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reserved_geckos (reservation_id INTEGER NOT NULL, gecko_id INTEGER NOT NULL, PRIMARY KEY(reservation_id, gecko_id), CONSTRAINT FK_E3283C8B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E3283C8FC45D556 FOREIGN KEY (gecko_id) REFERENCES gecko (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E3283C8FC45D556 ON reserved_geckos (gecko_id)');
        $this->addSql('CREATE INDEX IDX_E3283C8B83297E7 ON reserved_geckos (reservation_id)');
    }
}
