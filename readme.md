
# Laravel Queue Tracker

This package is designed to track the current job that is being processed within your queue, allowing you to see what is ongoing within the system.

> **Note:** This package has been primarily tested with sync and database. Other queue drivers might not work as expected.

![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/mpstr24/laravel-queue-tracker/run-tests.yml?branch=main)
![Packagist Version](https://img.shields.io/packagist/v/mpstr24/laravel-queue-tracker)
![Packagist Downloads](https://img.shields.io/packagist/dt/mpstr24/laravel-queue-tracker)

## Features

- Automatic polling of the current job
- Ability to target a specific queue

## Installation

Install the package via Composer:

```bash
composer require mpstr24/laravel-queue-tracker
```

## Usage/Examples

### Basic usage.
Run the following to see the current job being processed on "default" queue.

```bash
php artisan queue:track
```

### Queue selection

Use ```--queue``` to change the current queue you are tracking.

```bash
php artisan queue:track --queue=high
```

### Queue polling

Use ```--watch``` to poll the selected queue and see the jobs change. This polls every 5 seconds.

```bash
php artisan queue:track --watch
```

## Roadmap

- [ ] Tabular output if more than one job is currently processing.
- [ ] Config file for finer control
  - [ ] Polling control
  - [ ] Default queue control
- [ ] Job failure tracking
  - [ ] Error logging and analytics
- [ ] Larastan goals
    - [x] 5
    - [ ] 6
    - [ ] 7
    - [ ] 8
    - [ ] 9


## License

[MIT](https://choosealicense.com/licenses/mit/)

