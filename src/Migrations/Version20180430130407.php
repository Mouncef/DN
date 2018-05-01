<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180430130407 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tbl_payement DROP number, DROP description, DROP client_email, DROP client_id, DROP total_amount, DROP currency_code, DROP details');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tbl_payement ADD number VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD description VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD client_email VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD client_id VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD total_amount INT DEFAULT NULL, ADD currency_code VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD details JSON NOT NULL COMMENT \'(DC2Type:json_array)\'');
    }
}
