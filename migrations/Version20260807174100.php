<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to add active column to committee_member table, defaulting all records to inactive (0).
 */
final class Version20260807174100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add active column to committee_member table, defaulting all committee members to inactive (0)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE committee_member ADD active TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('UPDATE committee_member SET active = 0');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE committee_member DROP active');
    }
}
