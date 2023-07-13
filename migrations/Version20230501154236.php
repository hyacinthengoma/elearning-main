<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230501154236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, description_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, video_name VARCHAR(255) NOT NULL, video_url VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, subscribed TINYINT(1) NOT NULL, difficulty INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D5128A8F41807E1D (teacher_id), UNIQUE INDEX UNIQ_D5128A8FD9F966B (description_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_metas (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description_preview VARCHAR(255) NOT NULL, description_complete VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8F41807E1D FOREIGN KEY (teacher_id) REFERENCES teachers (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8FD9F966B FOREIGN KEY (description_id) REFERENCES training_metas (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8F41807E1D');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8FD9F966B');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE training_metas');
    }
}
