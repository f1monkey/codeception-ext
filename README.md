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