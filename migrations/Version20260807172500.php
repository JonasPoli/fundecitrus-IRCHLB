<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to add inside_shopping column to restaurant_recommendation table.
 */
final class Version20260807172500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add inside_shopping column to restaurant_recommendation table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE restaurant_recommendation ADD inside_shopping TINYINT(1) DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE restaurant_recommendation DROP inside_shopping');
    }
}
