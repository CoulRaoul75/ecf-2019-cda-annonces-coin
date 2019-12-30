<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191228180824 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__ad AS SELECT id, title, text, created_at, photo, price FROM ad');
        $this->addSql('DROP TABLE ad');
        $this->addSql('CREATE TABLE ad (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(80) NOT NULL COLLATE BINARY, text VARCHAR(200) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, price NUMERIC(10, 2) NOT NULL, photo VARCHAR(128) DEFAULT NULL, category_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO ad (id, title, text, created_at, photo, price) SELECT id, title, text, created_at, photo, price FROM __temp__ad');
        $this->addSql('DROP TABLE __temp__ad');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__ad AS SELECT id, title, text, created_at, photo, price FROM ad');
        $this->addSql('DROP TABLE ad');
        $this->addSql('CREATE TABLE ad (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(80) NOT NULL, text VARCHAR(200) NOT NULL, created_at DATETIME NOT NULL, price NUMERIC(10, 2) NOT NULL, photo VARCHAR(50) DEFAULT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO ad (id, title, text, created_at, photo, price) SELECT id, title, text, created_at, photo, price FROM __temp__ad');
        $this->addSql('DROP TABLE __temp__ad');
    }
}
