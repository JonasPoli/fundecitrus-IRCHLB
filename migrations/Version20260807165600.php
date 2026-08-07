<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to update registration_batch table with pricing matrix fields.
 */
final class Version20260807165600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update registration_batch table with hlb_price, iocv_price, full_price, period_text, and notes fields';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE registration_batch ADD hlb_price VARCHAR(100) DEFAULT NULL, ADD iocv_price VARCHAR(100) DEFAULT NULL, ADD full_price VARCHAR(100) DEFAULT NULL, ADD period_text VARCHAR(255) DEFAULT NULL, ADD notes LONGTEXT DEFAULT NULL, CHANGE price price NUMERIC(10, 2) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE registration_batch DROP hlb_price, DROP iocv_price, DROP full_price, DROP period_text, DROP notes, CHANGE price price NUMERIC(10, 2) NOT NULL');
    }
}
