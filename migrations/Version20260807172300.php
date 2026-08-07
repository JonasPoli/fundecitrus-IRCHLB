<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to add distance, walking_time, and driving_time to partner_hotel table.
 */
final class Version20260807172300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add distance, walking_time, and driving_time columns to partner_hotel table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE partner_hotel ADD distance VARCHAR(100) DEFAULT NULL, ADD walking_time VARCHAR(100) DEFAULT NULL, ADD driving_time VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE partner_hotel DROP distance, DROP walking_time, DROP driving_time');
    }
}
