<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230501162656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, description_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, course_price DOUBLE PRECISION NOT NULL, difficulty DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_169E6FB9D9F966B (description_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_course_metas (course_id INT NOT NULL, course_metas_id INT NOT NULL, INDEX IDX_250B8629591CC992 (course_id), INDEX IDX_250B86298A9D666D (course_metas_id), PRIMARY KEY(course_id, course_metas_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_metas (id INT AUTO_INCREMENT NOT NULL, meta_key_description_preview LONGTEXT NOT NULL, meta_val_preview_complete LONGTEXT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE learners (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3AB2D486E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher_metas (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description_preview VARCHAR(255) NOT NULL, description_complete VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teachers (id INT AUTO_INCREMENT NOT NULL, description_id INT NOT NULL, email VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_ED071FF6D9F966B (description_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, description_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, video_name VARCHAR(255) NOT NULL, video_url VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, subscribed TINYINT(1) NOT NULL, difficulty INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D5128A8F41807E1D (teacher_id), UNIQUE INDEX UNIQ_D5128A8FD9F966B (description_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_metas (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description_preview VARCHAR(255) NOT NULL, description_complete VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9D9F966B FOREIGN KEY (description_id) REFERENCES course_metas (id)');
        $this->addSql('ALTER TABLE course_course_metas ADD CONSTRAINT FK_250B8629591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_course_metas ADD CONSTRAINT FK_250B86298A9D666D FOREIGN KEY (course_metas_id) REFERENCES course_metas (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teachers ADD CONSTRAINT FK_ED071FF6D9F966B FOREIGN KEY (description_id) REFERENCES teacher_metas (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8F41807E1D FOREIGN KEY (teacher_id) REFERENCES teachers (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8FD9F966B FOREIGN KEY (description_id) REFERENCES training_metas (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9D9F966B');
        $this->addSql('ALTER TABLE course_course_metas DROP FOREIGN KEY FK_250B8629591CC992');
        $this->addSql('ALTER TABLE course_course_metas DROP FOREIGN KEY FK_250B86298A9D666D');
        $this->addSql('ALTER TABLE teachers DROP FOREIGN KEY FK_ED071FF6D9F966B');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8F41807E1D');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8FD9F966B');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE course_course_metas');
        $this->addSql('DROP TABLE course_metas');
        $this->addSql('DROP TABLE learners');
        $this->addSql('DROP TABLE teacher_metas');
        $this->addSql('DROP TABLE teachers');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE training_metas');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
