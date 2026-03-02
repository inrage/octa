# Octa Helm Chart

This document provides information about the Helm chart for deploying Octa, a WordPress theme based on Laravel, Bedrock, and Sage.

## Installation

```bash
# Add the repository (if applicable)
# helm repo add octa-repo <repository-url>

# Install the chart
helm install octa ./octa
```

## Configuration

The following table lists the configurable parameters of the Octa chart and their default values.

### General Configuration

| Parameter | Description | Default |
|-----------|-------------|---------|
| `replicaCount` | Number of replicas | `1` |
| `image.repository` | Image repository | `nginx` |
| `image.tag` | Image tag | `""` (defaults to chart appVersion) |
| `image.pullPolicy` | Image pull policy | `Always` |
| `app.environment` | Application environment | `production` |

### Database Configuration

| Parameter | Description | Default |
|-----------|-------------|---------|
| `mariadb.enabled` | Enable MariaDB | `true` |
| `mariadb.url` | MariaDB URL | `""` |
| `mariadb.auth.username` | MariaDB username | `octa` |
| `mariadb.auth.password` | MariaDB password | `!ThisMustBeChanged!` |
| `mariadb.auth.rootPassword` | MariaDB root password | `!ThisMustBeChanged!` |
| `mariadb.auth.database` | MariaDB database name | `octa` |

### Valkey Configuration (Redis-compatible)

| Parameter | Description | Default |
|-----------|-------------|---------|
| `valkey.enabled` | Enable Valkey | `false` |
| `valkey.token` | Valkey token | `""` |
| `valkey.auth.enabled` | Enable Valkey authentication | `false` |

### Uploads Volume Configuration

The chart now supports configuring a volume for uploads. This allows you to persist uploads across pod restarts and share them between replicas.

| Parameter | Description | Default |
|-----------|-------------|---------|
| `uploads.enabled` | Enable uploads volume | `true` |
| `uploads.hostPath` | Host path for uploads | `/data/website` |
| `uploads.containerPath` | Container path for uploads | `/var/www/html/public/content/uploads` |

### Mail Configuration

The chart supports conditional mail configuration with two modes:

| Parameter | Description | Default |
|-----------|-------------|---------|
| `mail.mailer` | Mail driver (native or smtps) | `native` |
| `mail.host` | SMTP host (only for smtps) | `""` |
| `mail.port` | SMTP port (only for smtps) | `""` |
| `mail.username` | SMTP username (only for smtps) | `""` |
| `mail.password` | SMTP password (only for smtps) | `""` |
| `mail.encryption` | SMTP encryption (only for smtps) | `""` |
| `mail.fromAddress` | From email address (only for smtps) | `""` |
| `mail.fromName` | From name (only for smtps) | `""` |

## Usage Examples

### Basic Installation

```bash
helm install octa ./octa
```

### Custom Uploads Path

To use a custom path for uploads on the host:

```bash
helm install octa ./octa --set uploads.hostPath=/custom/path/for/uploads
```

### Disable Uploads Volume

If you don't need the uploads volume:

```bash
helm install octa ./octa --set uploads.enabled=false
```

### Mail Configuration Examples

```bash
# Default installation (native mail)
helm install octa ./octa

# SMTP configuration
helm install octa ./octa \
  --set mail.mailer=smtps \
  --set mail.host=smtp.mailjet.com \
  --set mail.port=587 \
  --set mail.username=myusername \
  --set mail.password=mypassword \
  --set mail.encryption=tls \
  --set mail.fromAddress=noreply@example.com \
  --set mail.fromName="My App"
```

### Complete Example with Custom Configuration

```bash
helm install octa ./octa \
  --set app.environment=production \
  --set mariadb.auth.password=mySecurePassword \
  --set mariadb.auth.rootPassword=mySecureRootPassword \
  --set uploads.hostPath=/mnt/nfs/website-uploads \
  --set uploads.containerPath=/var/www/html/public/content/uploads \
  --set mail.mailer=smtps \
  --set mail.host=smtp.mailjet.com \
  --set mail.port=587
```

## Additional Volumes

If you need to mount additional volumes, you can use the `volumes` and `volumeMounts` parameters:

```yaml
volumes:
  - name: config-volume
    configMap:
      name: my-config

volumeMounts:
  - name: config-volume
    mountPath: /etc/config
    readOnly: true
```

These can be set using `--set-file` or by providing a values file.
