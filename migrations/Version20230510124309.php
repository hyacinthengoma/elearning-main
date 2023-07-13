<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230510124309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_metas ADD description_courte LONGTEXT NOT NULL, ADD description_complete LONGTEXT NOT NULL, DROP meta_key_description_preview, DROP meta_val_preview_complete, DROP name');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_metas ADD meta_key_description_preview LONGTEXT NOT NULL, ADD meta_val_preview_complete LONGTEXT NOT NULL, ADD name VARCHAR(255) NOT NULL, DROP description_courte, DROP description_complete');
    }
}
