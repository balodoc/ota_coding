<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250809071442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE approval_tokens (token VARCHAR(64) NOT NULL, action VARCHAR(16) NOT NULL, expires_at DATETIME NOT NULL, job_id INT NOT NULL, INDEX IDX_8EDED307BE04EA9 (job_id), PRIMARY KEY (token)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE external_jobs_cache (id INT AUTO_INCREMENT NOT NULL, external_id VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, url VARCHAR(2048) NOT NULL, raw_xml LONGTEXT DEFAULT NULL, fetched_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_899876C09F75D7B0 (external_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE job_posts (id INT AUTO_INCREMENT NOT NULL, poster_email VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, status VARCHAR(32) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_8901078AA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE notifications (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(64) NOT NULL, payload_json LONGTEXT NOT NULL, is_read TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE approval_tokens ADD CONSTRAINT FK_8EDED307BE04EA9 FOREIGN KEY (job_id) REFERENCES job_posts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_posts ADD CONSTRAINT FK_8901078AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE approval_tokens DROP FOREIGN KEY FK_8EDED307BE04EA9');
        $this->addSql('ALTER TABLE job_posts DROP FOREIGN KEY FK_8901078AA76ED395');
        $this->addSql('DROP TABLE approval_tokens');
        $this->addSql('DROP TABLE external_jobs_cache');
        $this->addSql('DROP TABLE job_posts');
        $this->addSql('DROP TABLE notifications');
        $this->addSql('DROP TABLE user');
    }
}
