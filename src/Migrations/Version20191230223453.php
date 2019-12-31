<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191230223453 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, first_name, name, address, postal_code, city, region, phone, email, password FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, first_name VARCHAR(50) DEFAULT NULL COLLATE BINARY, name VARCHAR(50) NOT NULL COLLATE BINARY, address VARCHAR(50) DEFAULT NULL COLLATE BINARY, postal_code NUMERIC(5, 0) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL COLLATE BINARY, region VARCHAR(80) DEFAULT NULL COLLATE BINARY, phone NUMERIC(10, 0) DEFAULT NULL, email VARCHAR(80) NOT NULL COLLATE BINARY, pwd VARCHAR(128) NOT NULL)');
        $this->addSql('INSERT INTO user (id, first_name, name, address, postal_code, city, region, phone, email, pwd) SELECT id, first_name, name, address, postal_code, city, region, phone, email, password FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, first_name, name, address, postal_code, city, region, phone, email, pwd FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, first_name VARCHAR(50) DEFAULT NULL, name VARCHAR(50) NOT NULL, address VARCHAR(50) DEFAULT NULL, postal_code NUMERIC(5, 0) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, region VARCHAR(80) DEFAULT NULL, phone NUMERIC(10, 0) DEFAULT NULL, email VARCHAR(80) NOT NULL, password VARCHAR(128) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO user (id, first_name, name, address, postal_code, city, region, phone, email, password) SELECT id, first_name, name, address, postal_code, city, region, phone, email, pwd FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }
}
