# TourKit — Bug Fix Plan

## Goal
Make the tour search flow actually filter results by all selected criteria and fix data/UX inconsistencies.

## Scope decisions
- Only functional bugs in the PHP flow; the HTML design reference (`references/design-reference.html`) is out of scope.
- Stars filter = minimum rating (`stars >= selected`).
- Price filter = maximum price (`price <= selected`), matching the single range input.
- Transport exact match after vocabulary unification.
- No DB migration; data stays in `db.php` array.

## Affected files
- `index.php` — search form
- `countries.php` — redirect handler
- `country.php` — results page
- `db.php` — tour data
- `header.php` — page title

## Tasks

1. **Fix form submission trigger** (`index.php`): rename button `name=" formSubmit"` → `name="formSubmit"` so `countries.php` redirect fires.

2. **Unify transport vocabulary** (`db.php`): change `"airplane"` → `"plane"` to match form option values (`bus`/`plane`/`train`).

3. **Normalize data types** (`db.php`): store `stars` and `price` as integers instead of strings for correct comparisons.

4. **Apply all filters** (`country.php`):
   - Read GET params with null-coalescing defaults (`country=UK`, `transport=`, `stars=1`, `price=1000`).
   - Cast `$stars`/`$price` to int.
   - Filter tours where `country` matches, (`transport` empty OR matches), `stars >= $stars`, `price <= $price`.
   - Show "no results" message when empty.
   - Escape all output with `htmlspecialchars`.

5. **Page title** (`header.php`): set `<title>TourKit — турагенство</title>`.

6. **Safety**: guard against undefined GET keys; validate `$stars` (1–5) and `$price` (100–1000) ranges, clamp if out of bounds.

## Edge cases
- Direct access to `country.php` without params → defaults, shows all tours for UK.
- Invalid transport value → no match (empty result + fallback message).
- Stars/price out of range → clamped to valid bounds.
- XSS via GET params → escaped.

## Validation
- Submit form for each country; verify redirect carries all params.
- Verify transport filter excludes non-matching tours.
- Verify stars/price filters narrow results.
- Empty result shows fallback message.
- No PHP notices in error log.