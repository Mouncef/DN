<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180218141903 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tbl_cart (cart_id INT AUTO_INCREMENT NOT NULL, user INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_BE83DD5F8D93D649 (user), PRIMARY KEY(cart_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lnk_article_cart (cart_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_F0BED7D51AD5CDBF (cart_id), INDEX IDX_F0BED7D57294869C (article_id), PRIMARY KEY(cart_id, article_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tbl_cart ADD CONSTRAINT FK_BE83DD5F8D93D649 FOREIGN KEY (user) REFERENCES tbl_user (user_id)');
        $this->addSql('ALTER TABLE lnk_article_cart ADD CONSTRAINT FK_F0BED7D51AD5CDBF FOREIGN KEY (cart_id) REFERENCES tbl_cart (cart_id)');
        $this->addSql('ALTER TABLE lnk_article_cart ADD CONSTRAINT FK_F0BED7D57294869C FOREIGN KEY (article_id) REFERENCES tbl_article (article_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lnk_article_cart DROP FOREIGN KEY FK_F0BED7D51AD5CDBF');
        $this->addSql('DROP TABLE tbl_cart');
        $this->addSql('DROP TABLE lnk_article_cart');
    }
}
