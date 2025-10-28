1. [ ] Replace the bespoke `ServicesJSON` implementation with PHP's native `json_encode`/`json_decode`, retaining loose-type behaviour via flags and ensuring proper `Content-Type` headers without emitting output during CLI/test execution.
2. [ ] Introduce centralized sanitization by refactoring all direct `$_GET`/`$_POST`/`$_REQUEST` usage to rely on `Xmf\Request` (or typed request DTOs), covering front-end scripts, admin controllers, and blocks.
3. [ ] Harden template and RSS loading endpoints (`dojson_loadtemplate.php`) against directory traversal by validating the requested template name against an allowlist and avoiding reuse of superglobals for temporary storage.
4. [ ] Replace the MD5/sha1-based passkey cookie mechanism with XOOPS token validation and password hashing via `password_hash`, handling missing indices safely before dereferencing cookies or POST data.
5. [ ] Add CSRF protection to all admin mass-action handlers that iterate raw `$_POST` payloads before executing database writes or permission changes.
6. [ ] Ensure all JSON/AJAX responses (e.g., `dojson_loadform.php`) consistently emit `Content-Type: application/json` headers using XOOPS' response helpers instead of manual `print` statements.
7. [ ] Guard SQL criteria builders against injection by casting IDs to integers and validating language codes before constructing Criteria objects, especially in block providers and handlers.
8. [ ] Audit and modernize file inclusion paths to prevent remote inclusion via configuration overrides; replace string concatenation with `XOOPS_ROOT_PATH` aware helpers and `Path::normalize`.
9. [ ] Adopt Composer-based autoloading for module classes and bundle PHPUnit as a dev dependency, adding CI configuration to run the new test suite.
10. [ ] Expand automated tests to cover content visibility rules (publish/expire, password-protected flows) using mocks/stubs for XOOPS handlers to catch regressions in permission logic.
