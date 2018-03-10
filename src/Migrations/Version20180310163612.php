<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180310163612 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tbl_cart DROP FOREIGN KEY FK_BE83DD5F8D93D649');
        $this->addSql('DROP INDEX IDX_BE83DD5F8D93D649 ON tbl_cart');
        $this->addSql('ALTER TABLE tbl_cart DROP user');
        $this->addSql('ALTER TABLE tbl_order ADD cart INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_order ADD CONSTRAINT FK_5B4DD987BA388B7 FOREIGN KEY (cart) REFERENCES tbl_cart (cart_id)');
        $this->addSql('CREATE INDEX IDX_5B4DD987BA388B7 ON tbl_order (cart)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tbl_cart ADD user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_cart ADD CONSTRAINT FK_BE83DD5F8D93D649 FOREIGN KEY (user) REFERENCES tbl_user (user_id)');
        $this->addSql('CREATE INDEX IDX_BE83DD5F8D93D649 ON tbl_cart (user)');
        $this->addSql('ALTER TABLE tbl_order DROP FOREIGN KEY FK_5B4DD987BA388B7');
        $this->addSql('DROP INDEX IDX_5B4DD987BA388B7 ON tbl_order');
        $this->addSql('ALTER TABLE tbl_order DROP cart');
    }
}
