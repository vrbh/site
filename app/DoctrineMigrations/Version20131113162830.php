<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131113162830 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE AccessToken ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL");
        $this->addSql("ALTER TABLE AuthCode ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL");
        $this->addSql("ALTER TABLE Client ADD name VARCHAR(255) DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL");
        $this->addSql("ALTER TABLE RefreshToken ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE AccessToken DROP created, DROP updated");
        $this->addSql("ALTER TABLE AuthCode DROP created, DROP updated");
        $this->addSql("ALTER TABLE Client DROP name, DROP description, DROP created, DROP updated");
        $this->addSql("ALTER TABLE RefreshToken DROP created, DROP updated");
    }
}
