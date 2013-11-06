<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131106204338 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE organisations ADD user_id INT DEFAULT NULL, ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL");
        $this->addSql("ALTER TABLE organisations ADD CONSTRAINT FK_D7E459ACA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)");
        $this->addSql("CREATE INDEX IDX_D7E459ACA76ED395 ON organisations (user_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE organisations DROP FOREIGN KEY FK_D7E459ACA76ED395");
        $this->addSql("DROP INDEX IDX_D7E459ACA76ED395 ON organisations");
        $this->addSql("ALTER TABLE organisations DROP user_id, DROP created, DROP updated");
    }
}
