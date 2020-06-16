# codeception-ext

Codeception modules and extensions

## Install
```
$ composer require f1monkey/codeception-ext
```
## Usage

### Extensions

#### SymfonyClearCacheExtension

Clear symfony cache pools before each test.
Example:
```yaml
extensions:
    enabled:
        -   \F1Monkey\Codeception\Extension\SymfonyClearCacheExtension:
                cache_pools: ['cache.app']
```

#### DoctrineDatabaseInitializeExtension

Clear database and create initial schema
```yaml
extensions:
    enabled:
        -   \F1Monkey\Codeception\Extension\DoctrineDatabaseInitializeExtension:
                pg_uuid_extension: true # load "uuid-ossp" postgres-extension
```