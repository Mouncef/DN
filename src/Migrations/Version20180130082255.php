<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180130082255 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tbl_slider');
        $this->addSql('DROP TABLE tbl_user');
        $this->addSql('ALTER TABLE dn_tbl_slider ADD slide_style VARCHAR(255) NOT NULL, ADD slide_video_name VARCHAR(255) DEFAULT NULL, CHANGE slide_name slide_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tbl_slider (slider_id INT AUTO_INCREMENT NOT NULL, slide_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, caption_1 VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, caption_2 VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(slider_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_user (user_id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, password VARCHAR(64) NOT NULL COLLATE utf8_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, roles JSON NOT NULL COMMENT \'(DC2Type:json_array)\', is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_38B383A1F85E0677 (username), UNIQUE INDEX UNIQ_38B383A1E7927C74 (email), PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dn_tbl_slider DROP slide_style, DROP slide_video_name, CHANGE slide_name slide_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
