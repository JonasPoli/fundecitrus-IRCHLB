<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Make event_date and main_title nullable in home_banner table.
 */
final class Version20260807161800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Make event_date and main_title nullable in home_banner table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE home_banner CHANGE event_date event_date VARCHAR(100) DEFAULT NULL, CHANGE main_title main_title VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE home_banner CHANGE event_date event_date VARCHAR(100) NOT NULL, CHANGE main_title main_title VARCHAR(255) NOT NULL');
    }
}
