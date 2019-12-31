<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191231130321 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title_category VARCHAR(50) NOT NULL)');
        $this->addSql('CREATE TABLE ad (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(80) NOT NULL, text VARCHAR(200) NOT NULL, created_at DATETIME NOT NULL, photo VARCHAR(128) DEFAULT NULL, price NUMERIC(10, 2) NOT NULL, category_id INTEGER DEFAULT NULL, user_id INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, first_name VARCHAR(50) DEFAULT NULL, name VARCHAR(50) NOT NULL, address VARCHAR(50) DEFAULT NULL, postal_code NUMERIC(5, 0) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, region VARCHAR(80) DEFAULT NULL, phone NUMERIC(10, 0) DEFAULT NULL, email VARCHAR(80) NOT NULL, pwd VARCHAR(128) NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE ad');
        $this->addSql('DROP TABLE user');
    }
}
