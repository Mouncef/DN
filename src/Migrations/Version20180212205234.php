<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180212205234 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tbl_collection ADD cover VARCHAR(255) DEFAULT NULL, ADD caption VARCHAR(255) DEFAULT NULL, ADD name VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD is_publicated TINYINT(1) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_950E2FA35E237E06 ON tbl_collection (name)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_950E2FA35E237E06 ON tbl_collection');
        $this->addSql('ALTER TABLE tbl_collection DROP cover, DROP caption, DROP name, DROP created_at, DROP updated_at, DROP is_publicated');
    }
}
