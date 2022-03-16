<?php

declare(strict_types=1);

/**
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>.
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180819203032 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE WebBundle_videos');
        $this->addSql('DROP TABLE mediasbundle_videos');
        $this->addSql('DROP TABLE usersbundle_users');
        $this->addSql('DROP TABLE webbundle_links');
        $this->addSql('DROP TABLE webbundle_pages');
        $this->addSql('DROP TABLE webbundle_partenaires');
        $this->addSql('ALTER TABLE videos CHANGE title title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE mediasbundle_medias CHANGE title title VARCHAR(255) DEFAULT NULL, CHANGE path path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE salt salt VARCHAR(255) DEFAULT NULL, CHANGE last_login last_login DATETIME DEFAULT NULL, CHANGE confirmation_token confirmation_token VARCHAR(180) DEFAULT NULL, CHANGE password_requested_at password_requested_at DATETIME DEFAULT NULL, CHANGE firstname firstname VARCHAR(255) DEFAULT NULL, CHANGE lastname lastname VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(20) DEFAULT NULL, CHANGE mobile mobile VARCHAR(20) DEFAULT NULL, CHANGE birthdate birthdate DATETIME DEFAULT NULL, CHANGE job job VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE partenaires CHANGE id_media id_media INT DEFAULT NULL');
        $this->addSql('ALTER TABLE discography_tracks CHANGE id_album id_album INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenements CHANGE id_media id_media INT DEFAULT NULL, CHANGE id_url id_url INT DEFAULT NULL, CHANGE id_season id_season INT DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE date_end date_end DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE blog_tags CHANGE weight weight SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE discography_albums CHANGE id_url id_url INT DEFAULT NULL, CHANGE id_media id_media INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pages CHANGE id_url id_url INT DEFAULT NULL');
        $this->addSql('ALTER TABLE blog_articles CHANGE id_url id_url INT DEFAULT NULL, CHANGE id_media id_media INT DEFAULT NULL, CHANGE id_video id_video INT DEFAULT NULL, CHANGE id_category id_category INT DEFAULT NULL, CHANGE published published DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE WebBundle_videos (id_video INT AUTO_INCREMENT NOT NULL, provider_id VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, title VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, provider VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id_video)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mediasbundle_videos (id_video INT AUTO_INCREMENT NOT NULL, provider_id VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, title VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, provider VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id_video)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usersbundle_users (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, lastname VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, phone VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, mobile VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, birthdate DATETIME DEFAULT \'NULL\', adresse LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, job VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, username VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, email VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, enabled TINYINT(1) NOT NULL, password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, salt VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, roles LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', username_canonical VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, email_canonical VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, last_login DATETIME DEFAULT \'NULL\', confirmation_token VARCHAR(180) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, password_requested_at DATETIME DEFAULT \'NULL\', UNIQUE INDEX UNIQ_26D39E4E92FC23A8 (username_canonical), UNIQUE INDEX UNIQ_26D39E4EA0D96FBF (email_canonical), UNIQUE INDEX UNIQ_26D39E4EC05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE webbundle_links (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, url VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT NOT NULL COLLATE utf8_unicode_ci, weight INT NOT NULL, public TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE webbundle_pages (id INT AUTO_INCREMENT NOT NULL, id_url INT DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, body LONGTEXT NOT NULL COLLATE utf8_unicode_ci, created DATETIME NOT NULL, updated DATETIME NOT NULL, public TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_ECA6CEB16AD2ADF4 (id_url), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE webbundle_partenaires (id_partenaire INT AUTO_INCREMENT NOT NULL, id_media INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, url VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_FAB04CAF84A9E03C (id_media), PRIMARY KEY(id_partenaire)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE webbundle_pages ADD CONSTRAINT FK_ECA6CEB16AD2ADF4 FOREIGN KEY (id_url) REFERENCES core_url (id_url)');
        $this->addSql('ALTER TABLE webbundle_partenaires ADD CONSTRAINT FK_FAB04CAF84A9E03C FOREIGN KEY (id_media) REFERENCES mediasbundle_medias (id_media)');
        $this->addSql('ALTER TABLE blog_articles CHANGE id_url id_url INT DEFAULT NULL, CHANGE id_media id_media INT DEFAULT NULL, CHANGE id_video id_video INT DEFAULT NULL, CHANGE id_category id_category INT DEFAULT NULL, CHANGE published published DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE blog_tags CHANGE weight weight SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE discography_albums CHANGE id_url id_url INT DEFAULT NULL, CHANGE id_media id_media INT DEFAULT NULL');
        $this->addSql('ALTER TABLE discography_tracks CHANGE id_album id_album INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenements CHANGE id_media id_media INT DEFAULT NULL, CHANGE id_url id_url INT DEFAULT NULL, CHANGE id_season id_season INT DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE date_end date_end DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE mediasbundle_medias CHANGE title title VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE path path VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE pages CHANGE id_url id_url INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partenaires CHANGE id_media id_media INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE salt salt VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE last_login last_login DATETIME DEFAULT \'NULL\', CHANGE confirmation_token confirmation_token VARCHAR(180) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE password_requested_at password_requested_at DATETIME DEFAULT \'NULL\', CHANGE firstname firstname VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE lastname lastname VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE phone phone VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE mobile mobile VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE birthdate birthdate DATETIME DEFAULT \'NULL\', CHANGE job job VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE videos CHANGE title title VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
