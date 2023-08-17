<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230806125751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment ADD teachers_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F84484365182 FOREIGN KEY (teachers_id) REFERENCES teachers (id)');
        $this->addSql('CREATE INDEX IDX_FE38F84484365182 ON appointment (teachers_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F84484365182');
        $this->addSql('DROP INDEX IDX_FE38F84484365182 ON appointment');
        $this->addSql('ALTER TABLE appointment DROP teachers_id');
    }
}
