<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180215205544 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ref_profil DROP FOREIGN KEY FK_93CFDA6EA76ED395');
        $this->addSql('DROP INDEX UNIQ_93CFDA6EA76ED395 ON ref_profil');
        $this->addSql('ALTER TABLE ref_profil DROP user_id');
        $this->addSql('ALTER TABLE tbl_user ADD profil INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_user ADD CONSTRAINT FK_38B383A1E6D6B297 FOREIGN KEY (profil) REFERENCES ref_profil (profil_id)');
        $this->addSql('CREATE INDEX IDX_38B383A1E6D6B297 ON tbl_user (profil)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ref_profil ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ref_profil ADD CONSTRAINT FK_93CFDA6EA76ED395 FOREIGN KEY (user_id) REFERENCES tbl_user (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_93CFDA6EA76ED395 ON ref_profil (user_id)');
        $this->addSql('ALTER TABLE tbl_user DROP FOREIGN KEY FK_38B383A1E6D6B297');
        $this->addSql('DROP INDEX IDX_38B383A1E6D6B297 ON tbl_user');
        $this->addSql('ALTER TABLE tbl_user DROP profil');
    }
}
