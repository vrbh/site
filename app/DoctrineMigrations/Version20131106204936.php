<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131106204936 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE product ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL");
        $this->addSql("ALTER TABLE fos_user ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL");
        $this->addSql("ALTER TABLE user_org ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL");
        $this->addSql("ALTER TABLE voorraad ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE fos_user DROP created, DROP updated");
        $this->addSql("ALTER TABLE product DROP created, DROP updated");
        $this->addSql("ALTER TABLE user_org DROP created, DROP updated");
        $this->addSql("ALTER TABLE voorraad DROP created, DROP updated");
    }
}
