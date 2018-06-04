<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180604213230 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tbl_param (param_id INT AUTO_INCREMENT NOT NULL, param_lib VARCHAR(255) DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, PRIMARY KEY(param_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tbl_user CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json_array)\'');
        $this->addSql('ALTER TABLE tbl_user ADD CONSTRAINT FK_38B383A1E6D6B297 FOREIGN KEY (profil) REFERENCES ref_profil (profil_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tbl_param');
        $this->addSql('ALTER TABLE tbl_user DROP FOREIGN KEY FK_38B383A1E6D6B297');
        $this->addSql('ALTER TABLE tbl_user CHANGE roles roles VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
