<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230818153626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE teachers_skill (teachers_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_C99389F684365182 (teachers_id), INDEX IDX_C99389F65585C142 (skill_id), PRIMARY KEY(teachers_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE teachers_skill ADD CONSTRAINT FK_C99389F684365182 FOREIGN KEY (teachers_id) REFERENCES teachers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teachers_skill ADD CONSTRAINT FK_C99389F65585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE teachers_skill DROP FOREIGN KEY FK_C99389F684365182');
        $this->addSql('ALTER TABLE teachers_skill DROP FOREIGN KEY FK_C99389F65585C142');
        $this->addSql('DROP TABLE teachers_skill');
    }
}
