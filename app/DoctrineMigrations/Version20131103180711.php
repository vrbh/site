<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131103180711 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, organisation_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D34A04AD9E6B1585 (organisation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE voorraad (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, INDEX IDX_B64943F54584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE product ADD CONSTRAINT FK_D34A04AD9E6B1585 FOREIGN KEY (organisation_id) REFERENCES organisations (id)");
        $this->addSql("ALTER TABLE voorraad ADD CONSTRAINT FK_B64943F54584665A FOREIGN KEY (product_id) REFERENCES product (id)");
        $this->addSql("DROP TABLE products");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE voorraad DROP FOREIGN KEY FK_B64943F54584665A");
        $this->addSql("CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, organisation_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_B3BA5A5A9E6B1585 (organisation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A9E6B1585 FOREIGN KEY (organisation_id) REFERENCES organisations (id)");
        $this->addSql("DROP TABLE product");
        $this->addSql("DROP TABLE voorraad");
    }
}
