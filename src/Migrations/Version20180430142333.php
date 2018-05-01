<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180430142333 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tbl_payement ADD state VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_pay_pal_detail ADD paypal_payment_id VARCHAR(255) DEFAULT NULL, ADD paypal_token VARCHAR(255) DEFAULT NULL, ADD paypal_payer_id VARCHAR(255) DEFAULT NULL, ADD paypal_total DOUBLE PRECISION DEFAULT NULL, ADD paypal_currency VARCHAR(255) DEFAULT NULL, ADD paypal_sub_total DOUBLE PRECISION DEFAULT NULL, ADD paypal_shipping DOUBLE PRECISION DEFAULT NULL, ADD paypal_merchant VARCHAR(255) DEFAULT NULL, ADD paypal_merchant_mail VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tbl_pay_pal_detail DROP paypal_payment_id, DROP paypal_token, DROP paypal_payer_id, DROP paypal_total, DROP paypal_currency, DROP paypal_sub_total, DROP paypal_shipping, DROP paypal_merchant, DROP paypal_merchant_mail');
        $this->addSql('ALTER TABLE tbl_payement DROP state');
    }
}
