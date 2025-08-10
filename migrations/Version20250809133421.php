<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250809133421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add jobId to notifications and index for faster lookups';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE notifications ADD job_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_NOTIFICATIONS_JOB_ID ON notifications (job_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX IDX_NOTIFICATIONS_JOB_ID ON notifications');
        $this->addSql('ALTER TABLE notifications DROP job_id');
    }
}


