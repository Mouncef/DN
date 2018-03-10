<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180310165250 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tbl_address (address_id INT AUTO_INCREMENT NOT NULL, adress_text LONGTEXT NOT NULL, city VARCHAR(150) NOT NULL, zip_code VARCHAR(10) NOT NULL, country VARCHAR(150) NOT NULL, PRIMARY KEY(address_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tbl_order ADD address INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_order ADD CONSTRAINT FK_5B4DD987D4E6F81 FOREIGN KEY (address) REFERENCES tbl_address (address_id)');
        $this->addSql('CREATE INDEX IDX_5B4DD987D4E6F81 ON tbl_order (address)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tbl_order DROP FOREIGN KEY FK_5B4DD987D4E6F81');
        $this->addSql('DROP TABLE tbl_address');
        $this->addSql('DROP INDEX IDX_5B4DD987D4E6F81 ON tbl_order');
        $this->addSql('ALTER TABLE tbl_order DROP address');
    }
}
