<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260818150308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agenda_activity RENAME INDEX idx_fa240a292881ddf8 TO IDX_AD2CBC3ED6228C4');
        $this->addSql('ALTER TABLE committee_member ADD email VARCHAR(255) DEFAULT NULL, ADD committees JSON DEFAULT NULL, CHANGE group_type group_type VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE supporter RENAME INDEX idx_813bb192f98f144a TO IDX_3F06E55F98F144A');
        $this->addSql('ALTER TABLE user CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE reset_password_expires_at reset_password_expires_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agenda_activity RENAME INDEX idx_ad2cbc3ed6228c4 TO IDX_FA240A292881DDF8');
        $this->addSql('ALTER TABLE committee_member DROP email, DROP committees, CHANGE group_type group_type VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE supporter RENAME INDEX idx_3f06e55f98f144a TO IDX_813BB192F98F144A');
        $this->addSql('ALTER TABLE user CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE reset_password_expires_at reset_password_expires_at DATETIME DEFAULT NULL');
    }
}
