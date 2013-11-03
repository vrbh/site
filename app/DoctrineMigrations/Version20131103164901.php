<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131103164901 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE organisations (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE user_org (id INT AUTO_INCREMENT NOT NULL, organisation_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_9903DB0B9E6B1585 (organisation_id), INDEX IDX_9903DB0BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE user_org ADD CONSTRAINT FK_9903DB0B9E6B1585 FOREIGN KEY (organisation_id) REFERENCES organisations (id)");
        $this->addSql("ALTER TABLE user_org ADD CONSTRAINT FK_9903DB0BA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE user_org DROP FOREIGN KEY FK_9903DB0B9E6B1585");
        $this->addSql("DROP TABLE organisations");
        $this->addSql("DROP TABLE user_org");
    }
}
