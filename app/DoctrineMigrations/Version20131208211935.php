<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131208211935 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE user_org_request (id INT AUTO_INCREMENT NOT NULL, organisation_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_E1F312C49E6B1585 (organisation_id), INDEX IDX_E1F312C4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE user_org_request ADD CONSTRAINT FK_E1F312C49E6B1585 FOREIGN KEY (organisation_id) REFERENCES organisations (id)");
        $this->addSql("ALTER TABLE user_org_request ADD CONSTRAINT FK_E1F312C4A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)");
        $this->addSql("ALTER TABLE product CHANGE stockUnit stockUnit VARCHAR(255) DEFAULT NULL, CHANGE orderUnit orderUnit VARCHAR(255) DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE user_org_request");
        $this->addSql("ALTER TABLE product CHANGE stockUnit stockUnit INT DEFAULT NULL, CHANGE orderUnit orderUnit INT DEFAULT NULL");
    }
}
