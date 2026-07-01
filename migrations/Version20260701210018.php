<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260701210018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agenda_activity (id INT AUTO_INCREMENT NOT NULL, event_day_id INT NOT NULL, room_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, type VARCHAR(100) NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_AD2CBC3E3B5B3674 (event_day_id), INDEX IDX_AD2CBC3E54177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agenda_activity_speaker (agenda_activity_id INT NOT NULL, speaker_id INT NOT NULL, INDEX IDX_8086C0ED321C8050 (agenda_activity_id), INDEX IDX_8086C0EDD04A0F27 (speaker_id), PRIMARY KEY(agenda_activity_id, speaker_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE airport_guide (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, distance VARCHAR(100) NOT NULL, transport VARCHAR(255) NOT NULL, position INT NOT NULL, INDEX IDX_BD01DBC03DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE committee_member (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, institution VARCHAR(255) NOT NULL, bio LONGTEXT NOT NULL, academic_link VARCHAR(255) DEFAULT NULL, linkedin_url VARCHAR(255) DEFAULT NULL, group_type VARCHAR(100) NOT NULL, position INT NOT NULL, INDEX IDX_69A4BB73DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_message (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, subject VARCHAR(100) NOT NULL, message LONGTEXT NOT NULL, consent TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, status VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_config (id INT AUTO_INCREMENT NOT NULL, hero_image_id INT DEFAULT NULL, prospectus_file_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) NOT NULL, event_dates VARCHAR(100) NOT NULL, location_name VARCHAR(255) NOT NULL, address_street VARCHAR(255) NOT NULL, address_neighborhood VARCHAR(255) NOT NULL, address_city VARCHAR(100) NOT NULL, address_zip_code VARCHAR(20) NOT NULL, google_maps_url LONGTEXT NOT NULL, hero_description LONGTEXT NOT NULL, support_email VARCHAR(180) NOT NULL, support_phone VARCHAR(50) NOT NULL, whatsapp_number VARCHAR(50) NOT NULL, linkedin_url VARCHAR(255) DEFAULT NULL, instagram_url VARCHAR(255) DEFAULT NULL, youtube_url VARCHAR(255) DEFAULT NULL, INDEX IDX_E613582E98BB94C5 (hero_image_id), INDEX IDX_E613582ED1AECEC (prospectus_file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_day (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, title VARCHAR(100) NOT NULL, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE example_entity (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, some_bool TINYINT(1) NOT NULL, some_list JSON DEFAULT NULL, some_date DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', sometime TIME DEFAULT NULL COMMENT \'(DC2Type:time_immutable)\', some_datetime DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status INT NOT NULL, INDEX IDX_AFE7E950A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE example_entity_user (example_entity_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C6E00128BB2FD451 (example_entity_id), INDEX IDX_C6E00128A76ED395 (user_id), PRIMARY KEY(example_entity_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faq_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faq_item (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, question VARCHAR(255) NOT NULL, answer LONGTEXT NOT NULL, position INT NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_1A054D7812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_content (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(100) NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_4A5DB3C989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partner_hotel (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, stars INT NOT NULL, description LONGTEXT NOT NULL, booking_code VARCHAR(50) DEFAULT NULL, booking_link VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, contact VARCHAR(100) DEFAULT NULL, position INT NOT NULL, INDEX IDX_106FF2BC3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registration_batch (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, position INT NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant_recommendation (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price_range VARCHAR(10) NOT NULL, category VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, location_url VARCHAR(255) DEFAULT NULL, position INT NOT NULL, INDEX IDX_B0FD74E83DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speaker (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, institution VARCHAR(255) NOT NULL, department VARCHAR(255) DEFAULT NULL, short_bio VARCHAR(255) NOT NULL, bio LONGTEXT NOT NULL, linkedin_url VARCHAR(255) DEFAULT NULL, instagram_url VARCHAR(255) DEFAULT NULL, facebook_url VARCHAR(255) DEFAULT NULL, youtube_url VARCHAR(255) DEFAULT NULL, whatsapp_url VARCHAR(255) DEFAULT NULL, scholar_url VARCHAR(255) DEFAULT NULL, lattes_url VARCHAR(255) DEFAULT NULL, research_areas JSON NOT NULL, is_featured TINYINT(1) NOT NULL, position INT NOT NULL, INDEX IDX_7B85DB613DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speaker_agenda (id INT AUTO_INCREMENT NOT NULL, speaker_id INT NOT NULL, event_date_text VARCHAR(100) NOT NULL, title VARCHAR(255) NOT NULL, time_location_text VARCHAR(150) NOT NULL, INDEX IDX_45DE9C36D04A0F27 (speaker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speaker_paper (id INT AUTO_INCREMENT NOT NULL, pdf_file_id INT DEFAULT NULL, speaker_id INT NOT NULL, title VARCHAR(255) NOT NULL, call_details VARCHAR(255) NOT NULL, INDEX IDX_7B8CDF85E071F843 (pdf_file_id), INDEX IDX_7B8CDF85D04A0F27 (speaker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sponsor (id INT AUTO_INCREMENT NOT NULL, logo_id INT DEFAULT NULL, tier_id INT NOT NULL, name VARCHAR(255) NOT NULL, website_url VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, stand_number VARCHAR(50) DEFAULT NULL, is_exhibitor TINYINT(1) NOT NULL, position INT NOT NULL, INDEX IDX_818CC9D4F98F144A (logo_id), INDEX IDX_818CC9D4A354F9DC (tier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sponsorship_inquiry (id INT AUTO_INCREMENT NOT NULL, company_name VARCHAR(255) NOT NULL, contact_person VARCHAR(255) NOT NULL, corporate_email VARCHAR(180) NOT NULL, interest_area VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, status VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sponsorship_tier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statistic_item (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(100) NOT NULL, value VARCHAR(50) NOT NULL, position INT NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thematic_group (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, event_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE venue_room (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, capacity INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agenda_activity ADD CONSTRAINT FK_AD2CBC3E3B5B3674 FOREIGN KEY (event_day_id) REFERENCES event_day (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agenda_activity ADD CONSTRAINT FK_AD2CBC3E54177093 FOREIGN KEY (room_id) REFERENCES venue_room (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE agenda_activity_speaker ADD CONSTRAINT FK_8086C0ED321C8050 FOREIGN KEY (agenda_activity_id) REFERENCES agenda_activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agenda_activity_speaker ADD CONSTRAINT FK_8086C0EDD04A0F27 FOREIGN KEY (speaker_id) REFERENCES speaker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE airport_guide ADD CONSTRAINT FK_BD01DBC03DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE committee_member ADD CONSTRAINT FK_69A4BB73DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE event_config ADD CONSTRAINT FK_E613582E98BB94C5 FOREIGN KEY (hero_image_id) REFERENCES image (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE event_config ADD CONSTRAINT FK_E613582ED1AECEC FOREIGN KEY (prospectus_file_id) REFERENCES image (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE example_entity ADD CONSTRAINT FK_AFE7E950A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE example_entity_user ADD CONSTRAINT FK_C6E00128BB2FD451 FOREIGN KEY (example_entity_id) REFERENCES example_entity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE example_entity_user ADD CONSTRAINT FK_C6E00128A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE faq_item ADD CONSTRAINT FK_1A054D7812469DE2 FOREIGN KEY (category_id) REFERENCES faq_category (id)');
        $this->addSql('ALTER TABLE partner_hotel ADD CONSTRAINT FK_106FF2BC3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE restaurant_recommendation ADD CONSTRAINT FK_B0FD74E83DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE speaker ADD CONSTRAINT FK_7B85DB613DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE speaker_agenda ADD CONSTRAINT FK_45DE9C36D04A0F27 FOREIGN KEY (speaker_id) REFERENCES speaker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE speaker_paper ADD CONSTRAINT FK_7B8CDF85E071F843 FOREIGN KEY (pdf_file_id) REFERENCES image (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE speaker_paper ADD CONSTRAINT FK_7B8CDF85D04A0F27 FOREIGN KEY (speaker_id) REFERENCES speaker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sponsor ADD CONSTRAINT FK_818CC9D4F98F144A FOREIGN KEY (logo_id) REFERENCES image (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE sponsor ADD CONSTRAINT FK_818CC9D4A354F9DC FOREIGN KEY (tier_id) REFERENCES sponsorship_tier (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agenda_activity DROP FOREIGN KEY FK_AD2CBC3E3B5B3674');
        $this->addSql('ALTER TABLE agenda_activity DROP FOREIGN KEY FK_AD2CBC3E54177093');
        $this->addSql('ALTER TABLE agenda_activity_speaker DROP FOREIGN KEY FK_8086C0ED321C8050');
        $this->addSql('ALTER TABLE agenda_activity_speaker DROP FOREIGN KEY FK_8086C0EDD04A0F27');
        $this->addSql('ALTER TABLE airport_guide DROP FOREIGN KEY FK_BD01DBC03DA5256D');
        $this->addSql('ALTER TABLE committee_member DROP FOREIGN KEY FK_69A4BB73DA5256D');
        $this->addSql('ALTER TABLE event_config DROP FOREIGN KEY FK_E613582E98BB94C5');
        $this->addSql('ALTER TABLE event_config DROP FOREIGN KEY FK_E613582ED1AECEC');
        $this->addSql('ALTER TABLE example_entity DROP FOREIGN KEY FK_AFE7E950A76ED395');
        $this->addSql('ALTER TABLE example_entity_user DROP FOREIGN KEY FK_C6E00128BB2FD451');
        $this->addSql('ALTER TABLE example_entity_user DROP FOREIGN KEY FK_C6E00128A76ED395');
        $this->addSql('ALTER TABLE faq_item DROP FOREIGN KEY FK_1A054D7812469DE2');
        $this->addSql('ALTER TABLE partner_hotel DROP FOREIGN KEY FK_106FF2BC3DA5256D');
        $this->addSql('ALTER TABLE restaurant_recommendation DROP FOREIGN KEY FK_B0FD74E83DA5256D');
        $this->addSql('ALTER TABLE speaker DROP FOREIGN KEY FK_7B85DB613DA5256D');
        $this->addSql('ALTER TABLE speaker_agenda DROP FOREIGN KEY FK_45DE9C36D04A0F27');
        $this->addSql('ALTER TABLE speaker_paper DROP FOREIGN KEY FK_7B8CDF85E071F843');
        $this->addSql('ALTER TABLE speaker_paper DROP FOREIGN KEY FK_7B8CDF85D04A0F27');
        $this->addSql('ALTER TABLE sponsor DROP FOREIGN KEY FK_818CC9D4F98F144A');
        $this->addSql('ALTER TABLE sponsor DROP FOREIGN KEY FK_818CC9D4A354F9DC');
        $this->addSql('DROP TABLE agenda_activity');
        $this->addSql('DROP TABLE agenda_activity_speaker');
        $this->addSql('DROP TABLE airport_guide');
        $this->addSql('DROP TABLE committee_member');
        $this->addSql('DROP TABLE contact_message');
        $this->addSql('DROP TABLE event_config');
        $this->addSql('DROP TABLE event_day');
        $this->addSql('DROP TABLE example_entity');
        $this->addSql('DROP TABLE example_entity_user');
        $this->addSql('DROP TABLE faq_category');
        $this->addSql('DROP TABLE faq_item');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE page_content');
        $this->addSql('DROP TABLE partner_hotel');
        $this->addSql('DROP TABLE registration_batch');
        $this->addSql('DROP TABLE restaurant_recommendation');
        $this->addSql('DROP TABLE speaker');
        $this->addSql('DROP TABLE speaker_agenda');
        $this->addSql('DROP TABLE speaker_paper');
        $this->addSql('DROP TABLE sponsor');
        $this->addSql('DROP TABLE sponsorship_inquiry');
        $this->addSql('DROP TABLE sponsorship_tier');
        $this->addSql('DROP TABLE statistic_item');
        $this->addSql('DROP TABLE thematic_group');
        $this->addSql('DROP TABLE venue_room');
    }
}
