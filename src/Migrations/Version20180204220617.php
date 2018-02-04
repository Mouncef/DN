<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180204220617 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tbl_article (article_id INT AUTO_INCREMENT NOT NULL, category INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, principal_cover VARCHAR(255) DEFAULT NULL, cover_second VARCHAR(255) DEFAULT NULL, cover_third VARCHAR(255) DEFAULT NULL, cover_fourth VARCHAR(255) DEFAULT NULL, is_published TINYINT(1) NOT NULL, is_available TINYINT(1) NOT NULL, INDEX IDX_5969061264C19C1 (category), PRIMARY KEY(article_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tbl_article ADD CONSTRAINT FK_5969061264C19C1 FOREIGN KEY (category) REFERENCES tbl_category (category_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tbl_article');
    }
}
