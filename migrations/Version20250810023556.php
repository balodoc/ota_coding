<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250810023556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE external_jobs_cache ADD subcompany VARCHAR(255) DEFAULT NULL, ADD office VARCHAR(255) DEFAULT NULL, ADD department VARCHAR(255) DEFAULT NULL, ADD recruiting_category VARCHAR(255) DEFAULT NULL, ADD employment_type VARCHAR(255) DEFAULT NULL, ADD seniority VARCHAR(255) DEFAULT NULL, ADD schedule VARCHAR(255) DEFAULT NULL, ADD years_of_experience VARCHAR(255) DEFAULT NULL, ADD keywords LONGTEXT DEFAULT NULL, ADD occupation VARCHAR(255) DEFAULT NULL, ADD occupation_category VARCHAR(255) DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_NOTIFICATIONS_JOB_ID ON notifications');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE external_jobs_cache DROP subcompany, DROP office, DROP department, DROP recruiting_category, DROP employment_type, DROP seniority, DROP schedule, DROP years_of_experience, DROP keywords, DROP occupation, DROP occupation_category, DROP created_at');
        $this->addSql('CREATE INDEX IDX_NOTIFICATIONS_JOB_ID ON notifications (job_id)');
    }
}
