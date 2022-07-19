<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220719081451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_import_process (id INT AUTO_INCREMENT NOT NULL, temp_data_id INT DEFAULT NULL, status INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, filename VARCHAR(255) NOT NULL, errors LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_4AF723848F3F95A3 (temp_data_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_table_data (id INT AUTO_INCREMENT NOT NULL, import_process_id INT DEFAULT NULL, row_id INT NOT NULL, col_id INT NOT NULL, valid TINYINT(1) NOT NULL, error LONGTEXT DEFAULT NULL, value LONGTEXT DEFAULT NULL, INDEX IDX_B13E18D4BC48CB67 (import_process_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_temp (id INT AUTO_INCREMENT NOT NULL, data LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', count_of_cells INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_import_process ADD CONSTRAINT FK_4AF723848F3F95A3 FOREIGN KEY (temp_data_id) REFERENCES app_temp (id)');
        $this->addSql('ALTER TABLE app_table_data ADD CONSTRAINT FK_B13E18D4BC48CB67 FOREIGN KEY (import_process_id) REFERENCES app_import_process (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_table_data DROP FOREIGN KEY FK_B13E18D4BC48CB67');
        $this->addSql('ALTER TABLE app_import_process DROP FOREIGN KEY FK_4AF723848F3F95A3');
        $this->addSql('DROP TABLE app_import_process');
        $this->addSql('DROP TABLE app_table_data');
        $this->addSql('DROP TABLE app_temp');
    }
}
