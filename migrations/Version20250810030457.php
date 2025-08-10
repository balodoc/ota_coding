<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250810030457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE job_posts ADD job_type VARCHAR(32) NOT NULL, ADD external_id VARCHAR(255) DEFAULT NULL, ADD url VARCHAR(2048) DEFAULT NULL, ADD raw_xml LONGTEXT DEFAULT NULL, ADD fetched_at DATETIME DEFAULT NULL, ADD subcompany VARCHAR(255) DEFAULT NULL, ADD office VARCHAR(255) DEFAULT NULL, ADD department VARCHAR(255) DEFAULT NULL, ADD recruiting_category VARCHAR(255) DEFAULT NULL, ADD employment_type VARCHAR(255) DEFAULT NULL, ADD seniority VARCHAR(255) DEFAULT NULL, ADD schedule VARCHAR(255) DEFAULT NULL, ADD years_of_experience VARCHAR(255) DEFAULT NULL, ADD keywords LONGTEXT DEFAULT NULL, ADD occupation VARCHAR(255) DEFAULT NULL, ADD occupation_category VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE job_posts DROP job_type, DROP external_id, DROP url, DROP raw_xml, DROP fetched_at, DROP subcompany, DROP office, DROP department, DROP recruiting_category, DROP employment_type, DROP seniority, DROP schedule, DROP years_of_experience, DROP keywords, DROP occupation, DROP occupation_category');
    }
}
