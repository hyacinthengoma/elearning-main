<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230427115237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course_course_metas (course_id INT NOT NULL, course_metas_id INT NOT NULL, INDEX IDX_250B8629591CC992 (course_id), INDEX IDX_250B86298A9D666D (course_metas_id), PRIMARY KEY(course_id, course_metas_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_course_metas ADD CONSTRAINT FK_250B8629591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_course_metas ADD CONSTRAINT FK_250B86298A9D666D FOREIGN KEY (course_metas_id) REFERENCES course_metas (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_course_metas DROP FOREIGN KEY FK_250B8629591CC992');
        $this->addSql('ALTER TABLE course_course_metas DROP FOREIGN KEY FK_250B86298A9D666D');
        $this->addSql('DROP TABLE course_course_metas');
    }
}
