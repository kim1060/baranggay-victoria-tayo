# APPOINTMATE - Docker Setup

This guide will help you run the APPOINTMATE PHP application using Docker without needing XAMPP or any local development dependencies.

## Prerequisites

- Docker and Docker Compose installed on your system
- No other software needed (PHP, MySQL, Apache are all handled by Docker)

## Quick Start

1. **Clone or navigate to the project directory:**

   ```bash
   cd /path/to/APPOINTMATE
   ```

2. **Build and start the application:**

   ```bash
   docker-compose up -d
   ```

3. **Access the application:**
   - **Main Application**: http://localhost:8080
   - **phpMyAdmin**: http://localhost:8081
     - Username: `root`
     - Password: `rootpassword`

## Services Included

- **Web Server**: PHP 8.2 with Apache
- **Database**: MySQL 8.0 with the appointmate database pre-loaded
- **phpMyAdmin**: Web interface for database management

## Database Information

- **Host**: `database` (internal Docker network)
- **Database**: `appointmate`
- **Root Password**: `rootpassword`
- **Application User**: `appuser`
- **Application Password**: `apppassword`

## Useful Commands

### Start the application

```bash
docker-compose up -d
```

### Stop the application

```bash
docker-compose down
```

### View logs

```bash
docker-compose logs -f web
```

### Rebuild after code changes

```bash
docker-compose down
docker-compose up -d --build
```

### Access the web container shell

```bash
docker-compose exec web bash
```

### Access MySQL directly

```bash
docker-compose exec database mysql -u root -p
```

## File Structure

- `Dockerfile` - PHP/Apache container configuration
- `docker-compose.yml` - Multi-container application setup
- `INCLUDE/config.docker.php` - Docker-specific database configuration
- `DATABASE/appointmate.sql` - Database schema and initial data

## Troubleshooting

### If the application doesn't start:

1. Make sure no other services are using ports 8080, 8081, or 3306
2. Check Docker logs: `docker-compose logs`

### If database connection fails:

1. Wait a few moments for MySQL to fully initialize
2. Check if the database container is running: `docker-compose ps`
3. Restart the services: `docker-compose restart`

### To reset the database:

```bash
docker-compose down -v
docker-compose up -d
```

## Development

The application files are mounted as volumes, so any changes you make to the code will be reflected immediately without rebuilding the container.

## Production Notes

For production deployment:

1. Change all default passwords in `docker-compose.yml`
2. Use environment variables for sensitive data
3. Configure proper SSL certificates
4. Set up proper backup strategies for the database
