<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230828201501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE teachers_categories (teachers_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_92DF9C2384365182 (teachers_id), INDEX IDX_92DF9C23A21214B7 (categories_id), PRIMARY KEY(teachers_id, categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE teachers_categories ADD CONSTRAINT FK_92DF9C2384365182 FOREIGN KEY (teachers_id) REFERENCES teachers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teachers_categories ADD CONSTRAINT FK_92DF9C23A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE teachers_categories DROP FOREIGN KEY FK_92DF9C2384365182');
        $this->addSql('ALTER TABLE teachers_categories DROP FOREIGN KEY FK_92DF9C23A21214B7');
        $this->addSql('DROP TABLE teachers_categories');
    }
}
