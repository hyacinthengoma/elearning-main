<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230815155209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment ADD course_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F84496EF99BF FOREIGN KEY (course_id_id) REFERENCES course (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FE38F84496EF99BF ON appointment (course_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F84496EF99BF');
        $this->addSql('DROP INDEX UNIQ_FE38F84496EF99BF ON appointment');
        $this->addSql('ALTER TABLE appointment DROP course_id_id');
    }
}
