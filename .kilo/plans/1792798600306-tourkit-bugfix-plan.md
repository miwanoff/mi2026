# TourKit — Design Integration Implementation Plan

## Goal
Correct the visual integration per `DESIGN-SPEC.md` and `references/design-reference.html`, preserving PHP structure, `db.php` data, and search flow.

## Constraints
- No new dependencies, DB, API, or paid services.
- Keep GET/POST flow and param names.
- Do not edit `references/design-reference.html`.
- Keep Ukrainian text and UTF-8.

## Stage 1 — Reference resolution & audit (done)
- Use `references/design-reference.html` as verified source.
- Update `DESIGN-SPEC.md` source name from `index.html` to `references/design-reference.html`.
- Verify: file exists and unchanged.

## Stage 2 — Data compliance decision
- Keep approved `db.php` changes (transport `airplane`→`plane`, int types, `img` field) with explicit approval; otherwise revert to original and handle mapping in PHP.
- Verify: `php -l db.php`; filters still match.

## Stage 3 — Header & footer
- `header.php`: skip link, sticky top bar, logo, burger, nav, (phone/admin optional), js flag script in head.
- `footer.php`: 3-column grid, disclaimer, TourKit branding only.
- Verify: lint; visual at desktop/mobile; no fictional contacts.

## Stage 4 — Hero & search form
- `index.php`: hero 5fr/6fr, chip/h1/paragraph without invented facts/dates; search form with existing fields and design classes.
- Verify: hero layout, overlap -56px, responsive stacking.

## Stage 5 — Catalog & cards
- `index.php` (#tours): render all tours as cards with image (if approved), place, name, facts available.
- `country.php`: filtered results as cards; empty state exact text + full catalog below.
- Verify: filters by country/transport/stars/price; empty state text exact.

## Stage 6 — JS & accessibility
- `js/scripts.js`: mobile nav toggle, scrolled header, IntersectionObserver reveal, reduced-motion fallback, price slider display.
- Verify: aria-expanded, focus outline, no horizontal overflow at 360px.

## Stage 7 — Validation & countries.php
- Normalize/clamp POST values; allowed lists; urlencode redirect.
- Verify: submit for each country; params carried.

## Stage 8 — Optional sections (omit)
- Popular destinations, hot offers, dialog/toast, admin dashboard: omit (no reliable data/handler).
- Document reasons in final report.

## Files to create/modify
- Modify: `header.php`, `footer.php`, `index.php`, `country.php`, `countries.php`, `js/scripts.js`, `css/style.css`, `db.php`, `DESIGN-SPEC.md`.
- No new files.

## Verification criteria per stage
- Stage 1: reference file unchanged; spec source name corrected.
- Stage 2: PHP lint; filter match test.
- Stage 3: lint; header/footer render; responsive.
- Stage 4: hero layout matches spec; no invented facts.
- Stage 5: cards render; empty state exact; filters work.
- Stage 6: JS no console errors; reduced-motion respected.
- Stage 7: form submission carries all params; clamping works.
- Stage 8: omissions documented.

## Open questions
- Confirm keeping `img` field in `db.php` (violates "no tour-card images" unless approved).
- Confirm whether to add phone/admin button in header (mock data).