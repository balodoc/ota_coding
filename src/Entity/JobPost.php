<?php

namespace App\Entity;

use App\Repository\JobPostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobPostRepository::class)]
#[ORM\Table(name: 'job_posts')]
class JobPost
{
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PENDING = 'pending';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_SPAM = 'spam';

    public const TYPE_INTERNAL = 'internal';
    public const TYPE_EXTERNAL = 'external';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?User $user = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $posterEmail;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'string', length: 32)]
    private string $status = self::STATUS_PENDING;

    #[ORM\Column(type: 'string', length: 32)]
    private string $jobType = self::TYPE_INTERNAL;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $updatedAt;

    // External job specific fields
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $externalId = null;

    #[ORM\Column(type: 'string', length: 2048, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $rawXml = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $fetchedAt = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $subcompany = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $office = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $department = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $recruitingCategory = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $employmentType = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $seniority = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $schedule = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $yearsOfExperience = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $keywords = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $occupation = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $occupationCategory = null;

    public function __construct(string $posterEmail, string $title, string $description, string $jobType = self::TYPE_INTERNAL)
    {
        $this->posterEmail = $posterEmail;
        $this->title = $title;
        $this->description = $description;
        $this->jobType = $jobType;
        $this->status = self::STATUS_PENDING;
        $now = new \DateTimeImmutable();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    public function getPosterEmail(): string
    {
        return $this->posterEmail;
    }

    public function setPosterEmail(string $posterEmail): void
    {
        $this->posterEmail = $posterEmail;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getJobType(): string
    {
        return $this->jobType;
    }

    public function setJobType(string $jobType): void
    {
        $this->jobType = $jobType;
    }

    public function isInternal(): bool
    {
        return self::TYPE_INTERNAL === $this->jobType;
    }

    public function isExternal(): bool
    {
        return self::TYPE_EXTERNAL === $this->jobType;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function touch(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    // External job specific getters and setters
    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(?string $externalId): void
    {
        $this->externalId = $externalId;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    public function getRawXml(): ?string
    {
        return $this->rawXml;
    }

    public function setRawXml(?string $rawXml): void
    {
        $this->rawXml = $rawXml;
    }

    public function getFetchedAt(): ?\DateTimeImmutable
    {
        return $this->fetchedAt;
    }

    public function setFetchedAt(?\DateTimeImmutable $fetchedAt): void
    {
        $this->fetchedAt = $fetchedAt;
    }

    public function getSubcompany(): ?string
    {
        return $this->subcompany;
    }

    public function setSubcompany(?string $subcompany): void
    {
        $this->subcompany = $subcompany;
    }

    public function getOffice(): ?string
    {
        return $this->office;
    }

    public function setOffice(?string $office): void
    {
        $this->office = $office;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(?string $department): void
    {
        $this->department = $department;
    }

    public function getRecruitingCategory(): ?string
    {
        return $this->recruitingCategory;
    }

    public function setRecruitingCategory(?string $recruitingCategory): void
    {
        $this->recruitingCategory = $recruitingCategory;
    }

    public function getEmploymentType(): ?string
    {
        return $this->employmentType;
    }

    public function setEmploymentType(?string $employmentType): void
    {
        $this->employmentType = $employmentType;
    }

    public function getSeniority(): ?string
    {
        return $this->seniority;
    }

    public function setSeniority(?string $seniority): void
    {
        $this->seniority = $seniority;
    }

    public function getSchedule(): ?string
    {
        return $this->schedule;
    }

    public function setSchedule(?string $schedule): void
    {
        $this->schedule = $schedule;
    }

    public function getYearsOfExperience(): ?string
    {
        return $this->yearsOfExperience;
    }

    public function setYearsOfExperience(?string $yearsOfExperience): void
    {
        $this->yearsOfExperience = $yearsOfExperience;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(?string $keywords): void
    {
        $this->keywords = $keywords;
    }

    public function getOccupation(): ?string
    {
        return $this->occupation;
    }

    public function setOccupation(?string $occupation): void
    {
        $this->occupation = $occupation;
    }

    public function getOccupationCategory(): ?string
    {
        return $this->occupationCategory;
    }

    public function setOccupationCategory(?string $occupationCategory): void
    {
        $this->occupationCategory = $occupationCategory;
    }
}
