# ChurchCMS

ChurchCMS is an open source church management platform built with Laravel 7, Vue 2, and Laravel Mix. It is designed for ministries that need a single system for member data, communication, sermons, events, prayer workflows, media, and community engagement.

Developed and maintained by GegoSoft Technologies (OPC) Private Limited, India.
Website: https://gegosoft.com

## Project links

- Marketing website: https://churchcms.app
- Community: https://github.com/church-cms
- Laravel repository: https://github.com/church-cms/church-cms-laravel
- Android mobile app repository: https://github.com/church-cms/church-cms-android
- Documentation repository: https://github.com/church-cms/church-cms-docs

## Why this project exists

Church teams often end up stitching together spreadsheets, messaging tools, livestream links, donation systems, and separate member directories. ChurchCMS brings those workflows together into one application so administrators, preachers, volunteers, and members can work from the same source of truth.

## Feature overview

- Member, guest, preacher, and sub-admin management
- Sermons, bulletins, audio, video, and gallery publishing
- Event calendars, attendance, reminders, and birthday notifications
- Prayer requests, community help workflows, and messaging tools
- Donation and fund management capabilities
- Newsletter, campaign, subscriber, and mailing-list features
- Mobile-app, push-notification, livestream, and conference integrations
- Role-based administration with audit-oriented activity logging

## Technology stack

- PHP 7.3 or 7.4
- Laravel 7
- Vue 2
- MySQL or MariaDB
- Node.js and npm for frontend assets
- Optional integrations for S3-compatible storage, Firebase Cloud Messaging, Twilio, Pusher, and analytics

## Getting started

### 1. Clone the repository

```bash
git clone <your-fork-or-repo-url>
cd church-cms-laravel
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Configure the environment

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with at least the following:

- Application URL
- Database credentials
- Mail configuration
- Storage configuration if you are not using local disk
- Any optional third-party service credentials you plan to enable

The committed `.env.example` only contains placeholders. Do not commit real secrets to the repository.

### 4. Prepare the database

```bash
php artisan migrate
php artisan db:seed
php artisan passport:install
```

### 5. Build frontend assets

```bash
npm run dev
```

For production builds:

```bash
npm run prod
```

### 6. Run the application

```bash
php artisan serve
```

Visit `http://127.0.0.1:8000` in your browser.

## Development workflow

Useful commands during local development:

```bash
php artisan serve
npm run watch
php artisan queue:work
```

If your instance uses local file uploads, create the storage symlink when needed:

```bash
php artisan storage:link
```

## Configuration notes

- Default local development uses file-based cache and sessions.
- The example environment defaults to local filesystem storage so the app can boot without S3.
- Push notifications, livestreaming, SMS, and analytics are optional and require extra service configuration.
- Review every third-party integration before enabling it in production.

## Testing

The repository includes PHPUnit and Laravel Dusk configuration, but application-level tests are not yet comprehensive. When contributing new behavior, add or update automated tests where practical.

Typical test commands:

```bash
./vendor/bin/phpunit
php artisan dusk
```

## Open source expectations

- Use issues for bug reports, regressions, and feature proposals.
- Keep pull requests focused and small enough to review.
- Avoid committing secrets, production data, or generated assets that do not belong in source control.
- Update documentation when behavior or setup changes.

## Contributing

Contribution guidelines are documented in [CONTRIBUTING.md](CONTRIBUTING.md).

## Maintainer

ChurchCMS is developed and maintained by GegoSoft Technologies (OPC) Private Limited, India.
Project website: https://gegosoft.com

## License

This project is licensed under the MIT License. See [LICENSE](LICENSE).
