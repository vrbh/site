<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131112210810 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE product ADD current_stock_id INT DEFAULT NULL, ADD description LONGTEXT NOT NULL, ADD orderNumber VARCHAR(255) DEFAULT NULL, ADD stock_unit INT NOT NULL, ADD order_unit INT NOT NULL");
        $this->addSql("ALTER TABLE product ADD CONSTRAINT FK_D34A04AD90B51B3A FOREIGN KEY (current_stock_id) REFERENCES voorraad (id)");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_D34A04AD90B51B3A ON product (current_stock_id)");
        $this->addSql("ALTER TABLE voorraad ADD amount INT NOT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD90B51B3A");
        $this->addSql("DROP INDEX UNIQ_D34A04AD90B51B3A ON product");
        $this->addSql("ALTER TABLE product DROP current_stock_id, DROP description, DROP orderNumber, DROP stock_unit, DROP order_unit");
        $this->addSql("ALTER TABLE voorraad DROP amount");
    }
}
