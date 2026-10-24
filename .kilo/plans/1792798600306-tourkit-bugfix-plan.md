# TourKit — Design Integration Plan

## Design source
`references/design-reference.html` (do not modify). Single-page "Обрій" travel site with CSS design tokens, responsive layout, card/grid UI. Tour data in that file is fictional and must NOT be imported — keep `db.php`.

## Goal
Apply the Claude design (tokens, typography, layout, cards, responsive grid) to the existing PHP templates while preserving search flow and `db.php` data.

## Constraints
- No new dependencies, DB, API, or paid services.
- Keep PHP structure and GET/POST param flow.
- Do not rewrite project from scratch.
- Do not edit `references/design-reference.html`.

## Files to change
- `css/style.css` — populate with design tokens + component styles extracted from reference (header, search, cards, grid, footer, responsive breakpoints).
- `header.php` — set lang="uk", title, include `css/style.css`, open `<main>`, top bar markup.
- `footer.php` — footer markup matching design, close tags, include Bootstrap/JS only if needed.
- `index.php` — hero + search form restyled with design classes; keep fields country/transport/stars/price and POST to countries.php.
- `country.php` — results rendered as design cards (name, country, stars, price, transport); keep filters (already implemented).
- `js/scripts.js` — optional minimal JS (mobile menu toggle). No data.

## Tasks
1. Extract `<style>` block from `references/design-reference.html` into `css/style.css`.
2. Update `header.php`/`footer.php` to design shell markup.
3. Restyle `index.php` form with design `.search`/`.field` classes; preserve form names.
4. Restyle `country.php` output as `.card` grid; escape values; keep filters.
5. Add mobile menu toggle in `js/scripts.js`.
6. Verify filters still narrow results; test responsive breakpoints.

## Risks
- Design reference is a JS app; only CSS + static markup reused, no JS data.
- Some design components (hot tours, admin panel) require data not in db.php — skip or mark out of scope.
- Transport vocabulary must stay unified (`plane`, not `airplane`).

## Fix: results page vertical spacing
- Symptom: search results page (`country.php`) has too-small top/bottom outer margins.
- Cause: content wrapped in `<div class="wrap">` with no vertical padding (design uses `section { padding-block: var(--sp-5) 0 }`).
- Change: wrap results content in `<section class="wrap" style="padding-block: var(--sp-4)">` (or add `.results` class with padding-block: 2.5rem). Keep `.wrap` width constraint.
- Files: `country.php` only.
- Validation: visual check top/bottom spacing on desktop/mobile.