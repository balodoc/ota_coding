<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250810040257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE approval_tokens DROP FOREIGN KEY `FK_8EDED307BE04EA9`');
        $this->addSql('DROP TABLE approval_tokens');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE approval_tokens (token VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, action VARCHAR(16) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, expires_at DATETIME NOT NULL, job_id INT NOT NULL, INDEX IDX_8EDED307BE04EA9 (job_id), PRIMARY KEY (token)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE approval_tokens ADD CONSTRAINT `FK_8EDED307BE04EA9` FOREIGN KEY (job_id) REFERENCES job_posts (id) ON DELETE CASCADE');
    }
}
