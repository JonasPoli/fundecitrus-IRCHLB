<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to add active and event_group columns to speaker table.
 */
final class Version20260807170500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add active and event_group columns to speaker table, defaulting active to false (0)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE speaker ADD active TINYINT(1) DEFAULT 0 NOT NULL, ADD event_group VARCHAR(50) DEFAULT NULL');
        $this->addSql('UPDATE speaker SET active = 0');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE speaker DROP active, DROP event_group');
    }
}
