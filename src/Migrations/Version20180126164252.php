<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180126164252 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE dn_tbl_slider (slider_id INT AUTO_INCREMENT NOT NULL, slide_name VARCHAR(255) NOT NULL, caption_1 VARCHAR(255) NOT NULL, caption_2 VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(slider_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dn_tbl_user (user_id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(64) NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json_array)\', is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_B4DEB2FAF85E0677 (username), UNIQUE INDEX UNIQ_B4DEB2FAE7927C74 (email), PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE tbl_slider');
        $this->addSql('DROP TABLE tbl_user');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tbl_slider (slider_id INT AUTO_INCREMENT NOT NULL, slide_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, caption_1 VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, caption_2 VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(slider_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_user (user_id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, password VARCHAR(64) NOT NULL COLLATE utf8_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, roles JSON NOT NULL COMMENT \'(DC2Type:json_array)\', is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_38B383A1F85E0677 (username), UNIQUE INDEX UNIQ_38B383A1E7927C74 (email), PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE dn_tbl_slider');
        $this->addSql('DROP TABLE dn_tbl_user');
    }
}
