<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180212204244 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tbl_collection (collection_id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(collection_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lnk_article_collection (collection_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_18D0800A514956FD (collection_id), INDEX IDX_18D0800A7294869C (article_id), PRIMARY KEY(collection_id, article_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lnk_article_collection ADD CONSTRAINT FK_18D0800A514956FD FOREIGN KEY (collection_id) REFERENCES tbl_collection (collection_id)');
        $this->addSql('ALTER TABLE lnk_article_collection ADD CONSTRAINT FK_18D0800A7294869C FOREIGN KEY (article_id) REFERENCES tbl_article (article_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lnk_article_collection DROP FOREIGN KEY FK_18D0800A514956FD');
        $this->addSql('DROP TABLE tbl_collection');
        $this->addSql('DROP TABLE lnk_article_collection');
    }
}
