<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230501175916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sub_categories DROP FOREIGN KEY FK_1638D5A512469DE2');
        $this->addSql('ALTER TABLE sub_categories DROP FOREIGN KEY FK_1638D5A55DC6FE57');
        $this->addSql('DROP TABLE sub_categories');
        $this->addSql('ALTER TABLE categories ADD sub_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668F7BFE87C FOREIGN KEY (sub_category_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_3AF34668F7BFE87C ON categories (sub_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sub_categories (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, subcategory_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_1638D5A512469DE2 (category_id), INDEX IDX_1638D5A55DC6FE57 (subcategory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sub_categories ADD CONSTRAINT FK_1638D5A512469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE sub_categories ADD CONSTRAINT FK_1638D5A55DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES sub_categories (id)');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668F7BFE87C');
        $this->addSql('DROP INDEX IDX_3AF34668F7BFE87C ON categories');
        $this->addSql('ALTER TABLE categories DROP sub_category_id');
    }
}
