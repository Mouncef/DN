<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180430134738 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tbl_brain_tree_detail (brain_tree_detail_id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(brain_tree_detail_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_pay_pal_detail (pay_pal_detail_id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(pay_pal_detail_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tbl_payement ADD paypal_detail INT DEFAULT NULL, ADD braintree_detail INT DEFAULT NULL, ADD date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_payement ADD CONSTRAINT FK_E5399EA8F35494F2 FOREIGN KEY (paypal_detail) REFERENCES tbl_pay_pal_detail (pay_pal_detail_id)');
        $this->addSql('ALTER TABLE tbl_payement ADD CONSTRAINT FK_E5399EA8DDB6D0FD FOREIGN KEY (braintree_detail) REFERENCES tbl_brain_tree_detail (brain_tree_detail_id)');
        $this->addSql('CREATE INDEX IDX_E5399EA8F35494F2 ON tbl_payement (paypal_detail)');
        $this->addSql('CREATE INDEX IDX_E5399EA8DDB6D0FD ON tbl_payement (braintree_detail)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tbl_payement DROP FOREIGN KEY FK_E5399EA8DDB6D0FD');
        $this->addSql('ALTER TABLE tbl_payement DROP FOREIGN KEY FK_E5399EA8F35494F2');
        $this->addSql('DROP TABLE tbl_brain_tree_detail');
        $this->addSql('DROP TABLE tbl_pay_pal_detail');
        $this->addSql('DROP INDEX IDX_E5399EA8F35494F2 ON tbl_payement');
        $this->addSql('DROP INDEX IDX_E5399EA8DDB6D0FD ON tbl_payement');
        $this->addSql('ALTER TABLE tbl_payement DROP paypal_detail, DROP braintree_detail, DROP date');
    }
}
