<p align="center">
    <img src="https://raw.githubusercontent.com/PHPoker/Poker/main/docs/logo-with-text.png?token=GHSAT0AAAAAACOB5QXSOKI3HID4JDELOR3WZOTDEPA" height="300" alt="PHPoker">
    <p align="center">
        <a href="https://github.com/nunomaduro/skeleton-php/actions"><img alt="GitHub Workflow Status (master)" src="https://github.com/nunomaduro/skeleton-php/actions/workflows/tests.yml/badge.svg"></a>
        <a href="https://packagist.org/packages/nunomaduro/skeleton-php"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/nunomaduro/skeleton-php"></a>
        <a href="https://packagist.org/packages/nunomaduro/skeleton-php"><img alt="Latest Version" src="https://img.shields.io/packagist/v/nunomaduro/skeleton-php"></a>
        <a href="https://packagist.org/packages/nunomaduro/skeleton-php"><img alt="License" src="https://img.shields.io/packagist/l/nunomaduro/skeleton-php"></a>
    </p>
</p>

------
PHP's Premier Poker Solution

> **Requires [PHP 8.2+](https://php.net/releases/)**

### ⚡️ Installation using [Composer](https://getcomposer.org):

```bash
composer require phpoker/poker
```

### ✨ Features

- Base classes for common card + poker related entities
    - Card
    - CardFace
    - CardSuit
    - CardCollection
- Evaluate
    - Highly optimized 5-card/7-card hand evaluators (port of Kevin "CactusKev" Suffecool's algorithm)

### Usage


### 🛠️ Development & Contributing

All contributions are welcomed -- bug fixes, features, ideas, criticisms, optimizations!

Take advantage of the included development tools:

🧹 Keep a modern codebase with **Laravel Pint**:
```bash
composer lint
```

✅ Run refactors using **Rector**
```bash
composer refacto
```

⚗️ Run static analysis using **PHPStan**:
```bash
composer test:types
```

✅ Run unit tests using **PEST**
```bash
composer test:unit
```

🚀 Run the entire test suite:
```bash
composer test
```

**PHPoker** was created by **[Nick Poulos](https://nickpoulos.info)** under the **[MIT license](https://opensource.org/licenses/MIT)**.
