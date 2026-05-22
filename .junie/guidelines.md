Style Guide:
- PSR-12

Build/Configuration Instructions:
- Requirements: PHP 8.3+ and Composer.
- Setup:
    1. Clone the repository.
    2. Run `composer install` to install dependencies.
    3. Ensure `src/` and `tests/` directories exist for PSR-4 autoloading (configured in `composer.json`).

Strict Typing:
- Always declare declare(strict_types=1); at the top of your PHP files to enforce strict data types on parameters and return values

Error Handling:
- Use try-catch blocks to handle exceptions gracefully, avoiding the disclosure of sensitive server information
- No `or die()`, no `exit()` for flow control
- No `@` (error suppression operator) — fix the root cause instead
- Throw domain-specific exceptions that extend `\RuntimeException` or `\LogicException`
- Use `set_exception_handler()` at the application boundary, not try/catch everywhere
- Log exceptions with context (request ID, user ID, stack trace) — not bare `error_log()`

Namespace conventions:
- All classes must be in a namespace matching the directory structure
- Follow PSR-4: `App\Http\Controllers\UserController` maps to `src/Http/Controllers/UserController.php`
- No procedural files at the root level except `index.php` (the bootstrap)
- One class per file, always
- Use Composer autoloading — no manual `require_once` chains

Target PHP 8.3+. Use:
- Named arguments for clarity over positional guessing
- Match expressions instead of switch/case with break
- Nullsafe operator (?->) instead of nested null checks
- Readonly properties for immutable data
- Enums instead of class constants for finite value sets
- First-class callable syntax where it improves readability

All function parameters, return types, and class properties must have type declarations:
- Use union types (int|string) rather than omitting types
- Use intersection types when a parameter must satisfy multiple interfaces
- Use never return type for functions that always throw or exit
- Avoid `mixed` except at true boundaries (serialization input, external API payloads)
- Use `void` for methods with no meaningful return value

Security rules (non-negotiable):
- All output in templates must be escaped: `htmlspecialchars($var, ENT_QUOTES, 'UTF-8')` or the framework equivalent
- CSRF tokens required on all state-mutating forms (POST, PUT, DELETE, PATCH)
- No `eval()`, no `shell_exec()`, no `system()` unless explicitly required (and reviewed)
- Passwords: `password_hash($pass, PASSWORD_ARGON2ID)` + `password_verify()`  — never MD5/SHA1
- Sessions: `session_regenerate_id(true)` after login
- File uploads: validate MIME type server-side, never trust the client-provided Content-Type

Prefer functional array operations over manual loops:
- `array_map()`, `array_filter()`, `array_reduce()` for collection transforms
- `array_column()` for plucking a field from a list of associative arrays
- Spread operator `[...$a, ...$b]` for merging instead of `array_merge()` in expressions
- Do not use `for ($i = 0; ...)` when `foreach` reads better
- Keep closures short — extract named functions if the closure exceeds 5 lines

Domain data:
- Use readonly classes (PHP 8.2) or readonly properties for value objects
- Value objects compare by value, not by reference — implement `equals()` if comparison is needed
- DTOs (Data Transfer Objects) must be readonly — no setters
- Money values: integer cents, never floats
- Dates: `\DateTimeImmutable` only — never mutable `\DateTime`

Testing conventions:
- PHPUnit 11+ for unit and integration tests
- Run tests using `./vendor/bin/phpunit`
- Test file: `tests/UserServiceTest.php` maps to `src/UserService.php`
- No `assertTrue(true)` — every test must assert observable behavior
- Avoid mocking internal implementation — mock only external boundaries (database, HTTP, filesystem)
- Data providers for edge cases, not copy-pasted test methods
- Test names must describe behavior: `test_throws_when_email_is_invalid()` or `testAddReturnsSum()`
- To add a new test:
    1. Create a class in `tests/` extending `PHPUnit\Framework\TestCase`.
    2. Add public methods prefixed with `test`.
    3. Run `./vendor/bin/phpunit` to execute.

Example Test:
```php
<?php
declare(strict_types=1);
namespace App\Tests;
use App\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase {
    public function testAdd(): void {
        $calc = new Calculator();
        $this->assertEquals(5, $calc->add(2, 3));
    }
}
```

Dependency management:
- All dependencies via Composer — no manual vendor directory manipulation
- Lock the exact PHP version in `composer.json` under `require`: `"php": ">=8.3"`
- Separate `require` (production) from `require-dev` (testing, analysis tools)
- Run `composer audit` before any dependency update — check for known vulnerabilities
- No packages abandoned on Packagist without a forked/maintained alternative

Logging:
- Use PSR-3 logger (Monolog or framework logger) — no bare `error_log()`
- Every log call must include context: `$logger->error('Payment failed', ['user_id' => $userId, 'amount' => $amount])`
- Log level discipline: debug (development only), info (normal operations), warning (degraded), error (failure requiring attention), critical (system down)
- No sensitive data in logs: mask card numbers, passwords, tokens before logging
- Structured logs preferred (JSON) for log aggregation