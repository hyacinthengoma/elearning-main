<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230501180750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course_categories (course_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_E51108EB591CC992 (course_id), INDEX IDX_E51108EBA21214B7 (categories_id), PRIMARY KEY(course_id, categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_categories ADD CONSTRAINT FK_E51108EB591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_categories ADD CONSTRAINT FK_E51108EBA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_categories DROP FOREIGN KEY FK_E51108EB591CC992');
        $this->addSql('ALTER TABLE course_categories DROP FOREIGN KEY FK_E51108EBA21214B7');
        $this->addSql('DROP TABLE course_categories');
    }
}
