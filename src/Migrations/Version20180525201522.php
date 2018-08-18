<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180525201522 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_26D39E4E92FC23A8 ON usersbundle_users');
        $this->addSql('DROP INDEX UNIQ_26D39E4EA0D96FBF ON usersbundle_users');
        $this->addSql('DROP INDEX UNIQ_26D39E4EC05FB297 ON usersbundle_users');
        $this->addSql('ALTER TABLE usersbundle_users DROP username, DROP username_canonical, DROP email, DROP email_canonical, DROP enabled, DROP salt, DROP password, DROP last_login, DROP confirmation_token, DROP password_requested_at, DROP roles, CHANGE firstname firstname VARCHAR(255) DEFAULT NULL, CHANGE lastname lastname VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(20) DEFAULT NULL, CHANGE mobile mobile VARCHAR(20) DEFAULT NULL, CHANGE birthdate birthdate DATETIME DEFAULT NULL, CHANGE job job VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE usersbundle_users ADD username VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, ADD username_canonical VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, ADD email VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, ADD email_canonical VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, ADD enabled TINYINT(1) NOT NULL, ADD salt VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, ADD password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD last_login DATETIME DEFAULT \'NULL\', ADD confirmation_token VARCHAR(180) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, ADD password_requested_at DATETIME DEFAULT \'NULL\', ADD roles LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE firstname firstname VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE lastname lastname VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE phone phone VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE mobile mobile VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8_unicode_ci, CHANGE birthdate birthdate DATETIME DEFAULT \'NULL\', CHANGE job job VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_26D39E4E92FC23A8 ON usersbundle_users (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_26D39E4EA0D96FBF ON usersbundle_users (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_26D39E4EC05FB297 ON usersbundle_users (confirmation_token)');
    }
}
