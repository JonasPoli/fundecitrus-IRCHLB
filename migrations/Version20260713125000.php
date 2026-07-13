<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to create organizer table and its foreign key constraints.
 */
final class Version20260713125000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create organizer table and its relation to image table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE organizer (id INT AUTO_INCREMENT NOT NULL, logo_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, website_url VARCHAR(255) DEFAULT NULL, position INT NOT NULL, INDEX IDX_99D47173F98F144A (logo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE organizer ADD CONSTRAINT FK_99D47173F98F144A FOREIGN KEY (logo_id) REFERENCES image (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE organizer DROP FOREIGN KEY FK_99D47173F98F144A');
        $this->addSql('DROP TABLE organizer');
    }
}
