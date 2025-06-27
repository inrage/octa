<p align="center">
<img src="https://static.inrage.fr/octa/octa-wordpress.jpg" alt="Octa WordPress" />
</p>

<p align="center">
  Octa is a Powerful WordPress theme based on Laravel, Bedrock and Sage
</p>

## Getting started

### Local development

1. Install Node dependencies:

```bash
pnpm install

```

2. Install Composer dependencies:

```bash
composer install
```

3. Create a `.env.local` file:

```bash
cp .env .env.local
```

## Configuration

```bash
PROJECT_NAME='octa'

DB_HOST='database'
DB_NAME='database_name'
DB_USER='database_user'
DB_PASSWORD='database_password'
DB_ROOT_PASSWORD='root_password'
```

### With docker

You can configure your environment variables in the `.env.local` file. By default, the Docker stack is configured to use the following environment variables:

### Without docker

You can configure your environment variables in the `.env.local` file.

```bash
PROJECT_NAME='octa'

DB_HOST='localhost'
DB_NAME='database_name'
DB_USER='database_user'
DB_PASSWORD='database_password'
```

### Start the development server

```bash
docker compose up -d
```
