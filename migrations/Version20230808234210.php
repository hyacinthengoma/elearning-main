<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230808234210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE teachers DROP FOREIGN KEY FK_ED071FF6D9F966B');
        $this->addSql('DROP INDEX UNIQ_ED071FF6D9F966B ON teachers');
        $this->addSql('ALTER TABLE teachers ADD description VARCHAR(255) DEFAULT NULL, DROP description_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE teachers ADD description_id INT DEFAULT NULL, DROP description');
        $this->addSql('ALTER TABLE teachers ADD CONSTRAINT FK_ED071FF6D9F966B FOREIGN KEY (description_id) REFERENCES teacher_metas (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ED071FF6D9F966B ON teachers (description_id)');
    }
}
