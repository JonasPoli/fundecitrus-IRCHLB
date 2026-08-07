<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration for diversas01 updates: home_banner titles/font size, agenda_activity thematic_group_id FK, and speaker committee_type.
 */
final class Version20260807195000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add main_title_line2 and title_font_size to home_banner, thematic_group_id FK to agenda_activity, and committee_type to speaker';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE home_banner ADD main_title_line2 VARCHAR(255) DEFAULT NULL, ADD title_font_size VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE agenda_activity ADD thematic_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agenda_activity ADD CONSTRAINT FK_FA240A292881DDF8 FOREIGN KEY (thematic_group_id) REFERENCES thematic_group (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_FA240A292881DDF8 ON agenda_activity (thematic_group_id)');
        $this->addSql('ALTER TABLE speaker ADD committee_type VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE home_banner DROP main_title_line2, DROP title_font_size');
        $this->addSql('ALTER TABLE agenda_activity DROP FOREIGN KEY FK_FA240A292881DDF8');
        $this->addSql('DROP INDEX IDX_FA240A292881DDF8 ON agenda_activity');
        $this->addSql('ALTER TABLE agenda_activity DROP thematic_group_id');
        $this->addSql('ALTER TABLE speaker DROP committee_type');
    }
}
