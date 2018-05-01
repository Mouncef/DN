<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180501194634 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tbl_address CHANGE city city VARCHAR(150) DEFAULT NULL, CHANGE country country VARCHAR(150) DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_brain_tree_detail ADD braintree_result_state TINYINT(1) DEFAULT NULL, ADD braintree_transaction_id VARCHAR(255) DEFAULT NULL, ADD braintree_transaction_state VARCHAR(255) DEFAULT NULL, ADD braintree_transaction_type VARCHAR(255) DEFAULT NULL, ADD braintree_transaction_amount DOUBLE PRECISION DEFAULT NULL, ADD braintree_transaction_created_at DATETIME DEFAULT NULL, ADD braintree_transaction_card_bin VARCHAR(50) DEFAULT NULL, ADD braintree_transaction_card_four_last VARCHAR(20) DEFAULT NULL, ADD braintree_transaction_card_type VARCHAR(50) DEFAULT NULL, ADD braintree_transaction_card_expired_at VARCHAR(50) DEFAULT NULL, ADD braintree_transaction_card_masked_number VARCHAR(50) DEFAULT NULL, ADD braintree_transaction_customer_location VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tbl_address CHANGE city city VARCHAR(150) NOT NULL COLLATE utf8_unicode_ci, CHANGE country country VARCHAR(150) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE tbl_brain_tree_detail DROP braintree_result_state, DROP braintree_transaction_id, DROP braintree_transaction_state, DROP braintree_transaction_type, DROP braintree_transaction_amount, DROP braintree_transaction_created_at, DROP braintree_transaction_card_bin, DROP braintree_transaction_card_four_last, DROP braintree_transaction_card_type, DROP braintree_transaction_card_expired_at, DROP braintree_transaction_card_masked_number, DROP braintree_transaction_customer_location');
    }
}
