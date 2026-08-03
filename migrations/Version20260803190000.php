<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to create supporter table and its foreign key constraints.
 */
final class Version20260803190000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create supporter table for supported by entities and its relation to image table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE supporter (id INT AUTO_INCREMENT NOT NULL, logo_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, website_url VARCHAR(255) DEFAULT NULL, position INT NOT NULL, INDEX IDX_813BB192F98F144A (logo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE supporter ADD CONSTRAINT FK_813BB192F98F144A FOREIGN KEY (logo_id) REFERENCES image (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE supporter DROP FOREIGN KEY FK_813BB192F98F144A');
        $this->addSql('DROP TABLE supporter');
    }
}
