<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260701225409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE home_banner (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, event_date VARCHAR(100) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, main_title VARCHAR(255) NOT NULL, description1 LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, button1_text VARCHAR(100) DEFAULT NULL, button1_link VARCHAR(255) DEFAULT NULL, button2_text VARCHAR(100) DEFAULT NULL, button2_link VARCHAR(255) DEFAULT NULL, position INT NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_9F99D15A3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE home_banner ADD CONSTRAINT FK_9F99D15A3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE home_banner DROP FOREIGN KEY FK_9F99D15A3DA5256D');
        $this->addSql('DROP TABLE home_banner');
    }
}
