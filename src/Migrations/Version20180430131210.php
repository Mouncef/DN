<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180430131210 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tbl_order ADD payment INT DEFAULT NULL, ADD order_total DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE tbl_order ADD CONSTRAINT FK_5B4DD9876D28840D FOREIGN KEY (payment) REFERENCES tbl_payement (payement_id)');
        $this->addSql('CREATE INDEX IDX_5B4DD9876D28840D ON tbl_order (payment)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tbl_order DROP FOREIGN KEY FK_5B4DD9876D28840D');
        $this->addSql('DROP INDEX IDX_5B4DD9876D28840D ON tbl_order');
        $this->addSql('ALTER TABLE tbl_order DROP payment, DROP order_total');
    }
}
