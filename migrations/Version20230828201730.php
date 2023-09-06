<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230828201730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE teachers_sub_category (teachers_id INT NOT NULL, sub_category_id INT NOT NULL, INDEX IDX_C968F2B084365182 (teachers_id), INDEX IDX_C968F2B0F7BFE87C (sub_category_id), PRIMARY KEY(teachers_id, sub_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE teachers_sub_category ADD CONSTRAINT FK_C968F2B084365182 FOREIGN KEY (teachers_id) REFERENCES teachers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teachers_sub_category ADD CONSTRAINT FK_C968F2B0F7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE teachers_sub_category DROP FOREIGN KEY FK_C968F2B084365182');
        $this->addSql('ALTER TABLE teachers_sub_category DROP FOREIGN KEY FK_C968F2B0F7BFE87C');
        $this->addSql('DROP TABLE teachers_sub_category');
    }
}
