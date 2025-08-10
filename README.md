# OTA Coding Challenge (Roland Tacadena)

## 🚀 Quick Start

### 1. Clone the Repository

```bash
git clone <repository-url>
cd ota_coding
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure Database
Edit `.env` and update the database configuration:

```env
DATABASE_URL="mysql://root:root@db/ota?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
```

### 4. Start the containers

```bash
docker-compose up --build
```

### 5. Ingest jobs from https://mrge-group-gmbh.jobs.personio.de/xml
```bash
php bin/console app:fetch-external-jobs
```

### 5. Visit the application

Your application will be available at `http://localhost:8080`
