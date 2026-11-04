# DESIGN-SPEC.md — «Обрій» travel catalog

**Source of truth:** the single-file design delivered as `references/design-reference.html`. Everything below is extracted from its markup, CSS and JS. Language: `<html lang="uk">`, all copy in Ukrainian.

**Scope note.** The existing PHP project (templates, `db.php`) was not available when this spec was written. File names for PHP templates are therefore **not** stated as facts; the agent must map sections to the project's real files (see §5).

---

## 1. Page structure (exact DOM order)

| # | Element | Selector | Status |
|---|---|---|---|
| 0 | Skip link «Перейти до змісту» → `#main` | `a.skip` | Optional (recommended, accessibility) |
| 1 | Sticky header: logo, nav, role-switch button | `header.site-header > .wrap.bar` | **Mandatory** |
| 2 | `<main id="main">` containing three views; only the catalog view is visible by default | `main#main` | **Mandatory** |
| 2.1 | Hero | `section.hero` | **Mandatory** |
| 2.2 | Search & filter panel (overlaps hero bottom) | `div.wrap > form.search-panel#searchForm` | **Mandatory** |
| 2.3 | Catalog: heading, result count, footnote, sorter, empty-state box, card grid | `section.block#catalog` | **Mandatory** |
| 2.4 | «Як ми організовуємо поїздку» — 3 numbered steps (dark teal band) | `section.steps` | Optional content section (include to match the design) |
| 2.5 | Tour details view (hidden until opened) | `#viewTour > .wrap#tourBox` | Mandatory only if the project has a tour-details page |
| 2.6 | Administrator financial report view (hidden) | `#viewAdmin` | Optional; only if the project has an admin/report page |
| 3 | Footer: brand blurb, contacts, office | `footer#contacts` | **Mandatory** |

Views 2.1–2.4 live in `#viewCatalog`; `[hidden]{display:none!important}` is the toggle.

### 1.1 Header
- Logo (left): `a.logo` «Обрій» + `<small>` «туристична агенція».
- `nav.nav` (right, `margin-left:auto`): «Каталог турів», «Гарячі тури», «Контакти» (→ `#contacts`), «Фінансовий звіт» (`#navAdmin`, hidden unless admin), and `button.role` «Режим: відвідувач / адміністратор» (`aria-pressed`).
- No hamburger menu exists. On narrow screens the nav wraps below the logo.

### 1.2 Hero
- Background `<img>` (Santorini/Oia, `width=2000 height=1333`, `fetchpriority=high`), dark gradient overlay, content bottom-left.
- Content order: eyebrow «Групові тури · листопад 2026 — березень 2027» → `h1` «Зима й весна в шести країнах» → lead paragraph → two buttons: «Обрати тур» (white fill, inline style `background:#fff;color:var(--c-teal-dark)`) and ghost «Лише гарячі тури».

### 1.3 Search panel (white card, overlaps hero by 5.5rem)
1. `.row.main`: search input (label «Пошук за назвою, країною, містом, готелем, ціною чи датою», `type=search`, placeholder «Наприклад: греція готель 2026 або 1290») · submit «Знайти» (`btn-primary`) · reset «Очистити пошук» (`btn-line`).
2. `details.adv#adv` (open by default), summary «Фільтри: напрямок, готель, ціна, дати», containing `.filters`:
   - «Країна» select (first option «Усі країни»), «Готель» select («Усі готелі»), «Ціна від, €» number (min 0, step 50, placeholder 0), «Ціна до, €» number (min 0, step 50, placeholder 3000).
   - `fieldset.dates` (legend «Дати»): radio group `name="dmode"` «Конкретна дата» (checked) / «Діапазон дат»; select «Враховувати» (`dep` «Дату відправлення», `arr` «Дату прибуття», `any` «Будь-який день туру»); date «Дата» (becomes «Дата від» in range mode); second date «Дата до» (`#d2f`, shown only in range mode); checkbox «Лише гарячі тури».

### 1.4 Catalog section
- `.head` (flex, space-between): left — `h2` «Каталог турів», `p.note#count` (`role=status aria-live=polite`; texts: «Усі тури: N», «Знайдено X з N турів», «Збігів не знайдено — нижче показано весь каталог.»), `p.note` «* Знижка на гарячі тури (−15%) — ілюстративна, для демонстрації.»; right — `.sorter`: select «Сортувати за» (Датою відправлення / Назвою (А–Я) / Тривалістю / Ціною) + direction button («За зростанням ↑» / «За спаданням ↓»).
- `#emptyBox.empty` (shown only with zero matches), exact text: `«На жаль, на Ваш запит інформація відсутня. Пропонуємо:»`, followed by the **full** catalog in the grid.
- `.grid#grid`: tour cards.

### 1.5 Tour card (DOM order inside `article.card`)
1. `a.card-img` (aria-hidden, tabindex -1) → `img` (600×450, lazy) + optional `.badge-hot` «Гарячий тур · −15%».
2. `.card-body`:
   - `p.route` «Країни: Місто → Місто» + `h3` tour name
   - `p.short`
   - `dl.meta`: Відправлення, Прибуття, Тривалість (wide), Транспорт (wide)
   - `ul.hotels` (hotel name left, stars right)
   - `.card-foot`: price block (struck-through old price for hot tours, `strong` current price, `small` «за особу») + seats line; button «Детальніше» (`btn-primary`, `aria-label="Детальніше про тур: …"`).

### 1.6 Steps section
`h2` «Як ми організовуємо поїздку»; `ol` of 3 `li` (each: CSS counter «01/02/03», `h4`, `p`): «Ви обираєте маршрут і дати», «Ми бронюємо та пишемо вам», «Група збирається в день вильоту».

### 1.7 Details view (when present)
Breadcrumbs → two-column `.detail` (photo | info) → `.after` two-column (about + hotel table | included list + back button).
- Info column: route, `h1`, big price (+ struck old price), `dl.facts` (Відправлення, Прибуття, Тривалість, Статус, Група, Вільні місця, Транспорт[wide]), booking form (name, phone, seats select, total, submit «Надіслати заявку»).
- `.after`: «Про тур», «Маршрут і готелі» table (Місто / Країна / Готель / Категорія), «Що включено» list, button «← До каталогу».

### 1.8 Admin view (when present)
Breadcrumbs, `h1` «Фінансовий звіт», note, 4 `.stat` cards (Вільних місць загалом; Вартість вільних місць; Продано місць; Виручка від проданих місць — last one `.stat.dark`), «Розбивка за турами» table with fill bar and totals row.

### 1.9 Footer
`.cols` three columns: (1) logo + blurb, (2) «Контакти» list (phone, mailto, hours), (3) «Офіс» list (address, link «Каталог турів»); below: `.legal` copyright line.

---

## 2. Design tokens

### 2.1 CSS variables (copy verbatim into `:root`)
```css
--c-ink:#12292c; --c-teal:#0e5a62; --c-teal-dark:#0a3f45;
--c-cream:#f8f5ef; --c-line:#e1dbcf; --c-hot:#b9501a;
--font-head:'Cormorant Garamond',Georgia,serif;
--font-body:'Manrope',system-ui,sans-serif;
--fs-h1:clamp(2.6rem,6.5vw,4.8rem);
--fs-h2:clamp(1.9rem,3.6vw,2.8rem);
--fs-h3:1.55rem; --fs-h4:1.1rem;
--fs-body:1rem; --fs-small:.875rem; --fs-btn:.95rem;
--btn-pad:.8rem 1.5rem; --btn-radius:999px;
--sp-1:.25rem; --sp-2:.5rem; --sp-3:1rem; --sp-4:1.5rem; --sp-5:2.5rem; --sp-6:4.5rem;
--radius:18px; --maxw:1180px;
```
Fonts (Google Fonts, Cyrillic): `Cormorant+Garamond:wght@500;600;700` and `Manrope:wght@400;500;600;700`, `display=swap&subset=cyrillic`.

### 2.2 Typography
- Body: Manrope 1rem / line-height 1.6, color `--c-ink`, background `--c-cream`.
- `h1,h2,h3`: Cormorant Garamond, weight 600, line-height 1.08, letter-spacing −.01em. `h4`: body font, 700, 1.1rem.
- Card `h3` 1.65rem; details `h1` `clamp(2.3rem,4.5vw,3.6rem)`; admin `h1` uses `--fs-h2`; details/after `h2` 2rem; admin sub-`h2` 1.8rem; booking `h2` 1.7rem.
- Logo: head font 1.9rem / 700 / line-height 1, color teal; `small` .64rem/1.2, weight 500, letter-spacing .16em, uppercase, color ink, margin-top .2rem.
- Labels/legend: .78rem, 700, letter-spacing .04em, uppercase, color `#4a5f62` (radio/checkbox labels: normal case, .92rem).
- Eyebrow: .78rem, 600, letter-spacing .14em, uppercase, opacity .9. Hero lead: 1.1rem, opacity .95.
- Meta `dt`: .7rem, 700, letter-spacing .08em, uppercase, `#6a7b7d`; `dd` weight 600.
- Prices: `strong` head font 600; card 1.9rem/1; details 3rem/1; stat 2.5rem/1.1.
- Buttons: `600 .95rem/1` Manrope.

### 2.3 Colors outside the variables (hard-coded in source)
`#fff` surfaces · `#4a5f62` labels · `#52676a` notes/breadcrumbs · `#6a7b7d` muted text · `#41575a` card short text · `#c98a12` stars (inactive `#d8d2c4`) · `#e8b27a` step numbers · `#c9c1b0` input hover border · `#cfc7b6` card hover border · `#faf7f0` row hover · `#f1ece1` table head · `#e9e3d6` bar track · `#e4f1ef` success message · `#cfe5e3` dark stat label · `#d7dfe0` footer text.
Header bg `rgba(248,245,239,.94)` + `backdrop-filter:blur(8px)`. Hero overlay `linear-gradient(180deg, rgba(10,63,69,.35) 0%, rgba(10,40,45,.78) 100%)`. Focus ring: `outline:3px solid var(--c-hot); outline-offset:2px`; input focus: border teal + `box-shadow:0 0 0 3px rgba(14,90,98,.18)`.

### 2.4 Radii, shadows, widths
- Radii: cards/panels 18px (`--radius`); inputs, fieldset, success message, table wrapper 12px; fact tiles 14px; buttons/badges/role button 999px.
- Shadows: search panel `0 20px 50px -20px rgba(10,40,45,.35)`; card hover `0 18px 36px -22px rgba(10,40,45,.5)`; booking card `0 14px 34px -24px rgba(10,40,45,.5)`; button hover `0 10px 20px -12px rgba(10,40,45,.6)`.
- Container: `.wrap{width:min(100% - 2.5rem, 1180px); margin-inline:auto}`.
- Borders: 1px `--c-line` (cards, panels, header); 1.5px for inputs, fieldset, `btn-line`, role button.

### 2.5 Breakpoints
`max-width:1020px` (tablet), `max-width:680px` (mobile), `prefers-reduced-motion:reduce`, `hover:hover` (hover effects only). No other breakpoints.

---

## 3. Components

### 3.1 Buttons
`.btn`: inline-flex, centered, gap .5rem, padding `--btn-pad`, radius pill, 1.5px transparent border, transition `background,color,border-color,transform,box-shadow .2s`.
- `.btn-primary`: bg teal, white text; hover bg teal-dark.
- `.btn-ghost`: transparent, `color:inherit`, border `currentColor`; hover bg `rgba(255,255,255,.14)` (used on dark hero).
- `.btn-line`: white bg, border `--c-line`, ink text; hover border and text teal.
- `[disabled]`: opacity .5, `cursor:not-allowed`.
- Hover (mouse devices only): `translateY(-1px)` + shadow; `:active` resets.

### 3.2 Header
Sticky (`top:0; z-index:50`), border-bottom 1px line. `.bar`: flex, align center, gap 1.5rem, `min-height:68px`, `flex-wrap:wrap`, `padding-block:.5rem`. Nav: flex, gap 1.5rem, align center, wrap. Links `.875rem/600`, no underline; hover: color teal and a 1.5px underline that grows left→right (`background-size` 0→100%, .3s). Role button: `600 .8rem`, padding `.5rem .9rem`, pill, 1.5px line border, white bg; `[aria-pressed=true]` → bg/border ink, white text.

### 3.3 Hero
`position:relative; color:#fff; min-height:min(78vh,640px); display:flex; align-items:flex-end; overflow:hidden; background:--c-teal-dark`. Image: absolute, inset 0, 100%×100%, `object-fit:cover`; overlay via `::after`. Content `.wrap` (relative, z-index 1) padding-block `4.5rem 8rem`. Left-aligned. `h1` `max-width:12ch`, margin-bottom 1rem; lead `max-width:48ch`, margin-bottom 1.5rem; buttons row flex, gap 1rem, wrap.

### 3.4 Search form
- Panel: `position:relative; z-index:2; margin-top:-5.5rem` (inside `.wrap`, after hero), bg white, radius 18, padding 1.5rem, 1px line border, shadow.
- `.row{display:grid; gap:1rem}`; `.row.main{grid-template-columns:1fr auto auto; align-items:end}`.
- `.field`: flex column, gap .35rem, `min-width:0`.
- Inputs/selects: width 100%, padding `.72rem .9rem`, border 1.5px line, radius 12, bg cream, `min-height:46px`, font inherit; hover border `#c9c1b0`.
- Advanced block: `details.adv` margin-top 1rem, border-top 1px line, padding-top 1rem; summary: bold, `.875rem`, flex space-between, marker removed, custom `+` / `−` (1.3rem) via `::after`, hover color teal.
- `.filters`: grid 4 equal columns, gap 1rem, margin-top 1rem. `fieldset.dates`: `grid-column:1/-1`, 1.5px line border, radius 12, padding 1rem, grid 4 equal columns, gap 1rem, `align-items:end`, `min-width:0`; `.radios` spans all columns (flex, gap 1rem, wrap). Checkbox/radio: `accent-color` teal (radio) / hot (checkbox), `width:auto`.

### 3.5 Catalog heading, sorter, empty state
`section.block` padding-block `2.5rem 4.5rem`. `.head`: flex, space-between, align end, gap 1rem, wrap, margin-bottom 1.5rem. `.note`: `.875rem`, `#52676a`. `.sorter`: flex, gap .5rem, align end; its `.field` `min-width:200px`. `.empty`: white bg, 1.5px **dashed** teal border, radius 18, padding 1.5rem, margin-bottom 1.5rem; text in head font 1.7rem/600.

### 3.6 Tour card
- Grid: 3 equal columns, gap 1.5rem.
- Card: white, 1px line, radius 18, `overflow:hidden`, flex column. Hover (mouse): `translateY(-4px)`, shadow, border `#cfc7b6`; image scales 1.05 (.8s).
- Image: `aspect-ratio:4/3`, `object-fit:cover`, placeholder bg `--c-line`.
- Badge: absolute `left:.8rem; top:.8rem`, bg `--c-hot`, white, `.75rem/700`, letter-spacing .06em, uppercase, padding `.35rem .7rem`, pill. Text: «Гарячий тур · −15%».
- Body: padding 1.5rem, flex column, gap 1rem, `flex:1`.
- `p.route`: `.875rem/700`, teal. `p.short`: `.95rem`, `#41575a`.
- `dl.meta`: 2-col grid, gap `.5rem 1rem`, `.875rem`; `.wide` spans both.
- `ul.hotels`: no bullets, `.875rem`, gap .25rem; each `li` flex space-between gap .5rem; stars `★` ×rating in `#c98a12`, remaining `★` in `#d8d2c4`, `letter-spacing:.08em`, with `role=img aria-label="N з 5 зірок"`.
- `.card-foot`: `margin-top:auto`, flex space-between, align end, gap 1rem, padding-top 1rem, border-top 1px line.
- Price: old price `<s>` `.875rem` `#6a7b7d` on its own line; current `strong` head font 1.9rem; **hot tours:** current price in `--c-hot`; `small` «за особу» `.72rem`.
- Seats: `.875rem/600`; «Залишилось N місць із M» in `--c-hot` when ≤5; «Вільно N місць із M» otherwise; «Місць немає» in hot color at 0.
- Formats: dates `dd.mm.yyyy`; money `Intl.NumberFormat('uk-UA',{style:'currency',currency:'EUR',maximumFractionDigits:0})` → «1 290 €»; duration «8 днів / 7 ночей» (Ukrainian plural rules; days = arrival − departure + 1); seat word plural «місце/місця/місць».

### 3.7 Steps band
bg teal-dark, white text, padding-block 4.5rem. `ol`: no markers, 3 equal columns, gap 2.5rem, margin-top 1.5rem. `li`: border-top `1px solid rgba(255,255,255,.3)`, padding-top 1rem; `::before` counter `"0"+n` in head font `600 2.4rem/1`, color `#e8b27a`, display block, margin-bottom .5rem. `p`: `.95rem`, opacity .85, `max-width:34ch`.

### 3.8 Details view
Breadcrumbs `.crumbs` (`.875rem`, `#52676a`, current item ink/700). `.detail`: grid `1.1fr 1fr`, gap 2.5rem, `align-items:start`. Photo: `aspect-ratio:4/5`, radius 18, cover, badge repeated. `.facts`: 2 columns, gap 1rem; `.fact` white, 1px line, radius 14, padding `.8rem 1rem`; `.fact.wide` spans 2. Booking `.book`: white, 1px line, radius 18, padding 1.5rem, grid gap 1rem, shadow; `.total` row bold with top border. `.msg`: bg `#e4f1ef`, color teal-dark, 600, radius 12, padding `.8rem 1rem`. `.after`: grid `1.3fr 1fr`, gap 2.5rem, margin-top 2.5rem, padding-bottom 4.5rem; list `padding-left:1.1rem`, gap .4rem. Tables: full width, `.875rem`, white, 1px line, radius 12; `th` `.72rem/700` uppercase, letter-spacing .08em, bg `#f1ece1`, color `#4a5f62`; cells padding `.7rem .9rem`; numeric cells right-aligned, no wrap; scroll wrapper `.scroll{overflow-x:auto}` with `table{min-width:620px}`.

### 3.9 Admin view
Container padding-block `2.5rem 4.5rem`. `.cards4`: 4 equal columns, gap 1rem, margin-block 1.5rem. `.stat`: white, 1px line, radius 18, padding 1.5rem; label `.75rem/700` uppercase `#6a7b7d`; value head font 2.5rem/1.1; `.stat.dark` bg/border teal, white text, label `#cfe5e3`. Fill bar: track 8px high, pill, `#e9e3d6`, `min-width:90px`; fill teal. Totals in `tfoot`.

### 3.10 Footer
bg ink, text `#d7dfe0`, padding-block 2.5rem. `.cols`: grid `1.4fr 1fr 1fr`, gap 2.5rem. `h4` white, margin-bottom .5rem; `p`/`li` `.875rem`; lists unstyled, gap .3rem; links no underline (underline on hover); logo white; blurb `max-width:36ch`, margin-top 1rem. `.legal`: margin-top 1.5rem, padding-top 1rem, border-top `1px solid rgba(255,255,255,.15)`, `.8rem`, opacity .7.

### 3.11 Motion (pure CSS + tiny JS, safe to reuse)
- Keyframes: `fadeUp` (opacity 0, translateY 18px), `fadeDown` (translateY −6px), `fadeOnly` (opacity .35), `heroZoom` (scale 1.07→1), `grow` (scaleX 0→1).
- Hero image `heroZoom 1.8s`; hero children `fadeUp .8s` with delays .15/.27/.39/.51s.
- Scroll reveal: `<html>` gets class `js` from an inline head script; elements with class `pre` are `opacity:0` (only under `.js`); an `IntersectionObserver` (threshold .12, rootMargin `0 0 -6% 0`) swaps `pre` → `go` (`fadeUp .7s`, delay `var(--d)`). Applied to: search panel, `.head`, cards (first render only, `--d` = (index%3)·80ms), steps `h2` and `li` (`--d` 0/90/180ms), footer `.cols`. Later card re-renders use class `fade` (.3s).
- Other: details/admin views `fadeUp .5s`; stat cards staggered .07s; bar fill `grow .9s`; `.msg`, `.empty`, `#d2f`, opened `.filters` use `fadeDown .35s`.
- `prefers-reduced-motion: reduce`: all animation and transition disabled; `.js .pre{opacity:1}`.

---

## 4. Responsive behavior

| Section | > 1020px | ≤ 1020px | ≤ 680px |
|---|---|---|---|
| Header/nav | one row, nav right | unchanged | nav `margin-left:0; width:100%; gap:1rem`, wraps under logo (no hamburger) |
| Hero | padding-bottom 8rem | unchanged | padding-bottom 7rem; `min-height` formula unchanged |
| Search `.row.main` | 3 cols `1fr auto auto` | unchanged | 1 column (input, then both buttons stacked) |
| `.filters` | 4 cols | 2 cols | 1 col |
| `fieldset.dates` | 4 cols | 2 cols | 1 col |
| Advanced `<details>` | open | open | **closed on load** (JS: `matchMedia('(max-width:680px)')`) |
| Sorter | right of heading (wraps if needed) | same | `width:100%`, field `flex:1; min-width:0` |
| Card grid | 3 cols | 2 cols | 1 col |
| Steps `ol` | 3 cols | 3 cols | 1 col |
| Details `.detail`, `.after` | 2 cols | 1 col; photo `aspect-ratio:16/10` | 1 col; `.facts` 1 col |
| Admin `.cards4` | 4 cols | 2 cols | 1 col |
| Admin table | — | — | horizontal scroll (`min-width:620px` inside `.scroll`) |
| Footer `.cols` | 3 cols | 3 cols | 1 col |

Container is always `100% − 2.5rem` side gutter (1.25rem per side) up to 1180px. Hover transforms apply only under `@media (hover:hover)`, so touch devices get none.

---

## 5. PHP integration mapping

**Rules**
1. The reference is a static prototype: its form has **no `action`, no `method`, and no `name` attributes** (only `id`s, plus `name="dmode"` on radios). The PHP form must keep its **existing** `method` (GET/POST), `action`, field `name`s and request handling exactly; only wrapper markup, classes and CSS change.
2. Tour data comes **only** from the project's `db.php` (existing queries/functions). Never copy the `TOURS` array, tour names, hotels, prices, photos, seat counts or the 15% discount from the reference.
3. Do not move search/filter/sort logic to JavaScript. Server-rendered results are the source of truth.

**Section → template mapping** (locate the real files; do not assume names)

| Design section | Map to the project's… | Visual task | PHP task (unchanged) |
|---|---|---|---|
| Skip link, `<head>` (fonts link, `lang="uk"`, inline `js` class script), header, footer | shared layout/partials (header/footer includes) | Add tokens CSS, header and footer markup/classes | Keep existing links/URLs, session/role logic if any |
| Hero | catalog/home template | Hero markup, copy may be edited | Static; hero copy claims («шести країнах», dates) must match real data or be removed |
| Search panel | catalog template where the search form lives | Re-style existing form into the `.row.main` + `details.adv` + `.filters` layout | Preserve every existing field, `name`, method, validation, sticky values (re-populate `value`/`selected`/`checked`) and the clear/reset action |
| Count, sorter, empty state, grid | catalog template | `.head`, sorter, `.empty`, `.grid` | Loop over rows returned by `db.php`; empty result → print the exact message `«На жаль, на Ваш запит інформація відсутня. Пропонуємо:»` then the full catalog (if the project already does this, keep its logic) |
| Tour card | card partial/loop body | Card markup per §1.5 | Fill from DB fields; compute duration, discount and seat text in PHP from real data; escape with `htmlspecialchars` |
| Steps band | catalog template (optional) | Include as static section | Static copy; review the promises in it (e.g. «Протягом доби…») before publishing |
| Details view | tour details template, if present | §3.8 layout | Real tour by id from `db.php`; booking form only if the project already has booking handling — the reference form is a client-side demo that decrements seats in memory |
| Admin report | existing admin/report template, if present | §3.9 layout | Real aggregates from DB; access control stays server-side. Do not add one if the project has none |

**Safe to reuse**
- `:root` tokens and all layout/component CSS (§2–§3), including `[hidden]`, focus styles and the reduced-motion block.
- Header, hero, search-panel, card, steps, footer markup structure and classes.
- Motion CSS and the small `reveal()` IntersectionObserver snippet (data-independent). On PHP pages with no client-side re-rendering, cards simply carry `class="card pre"` and `--d`.
- `.btn*`, `.field`, `.note`, `.badge-hot`, `.stars` styles; `matchMedia` snippet that closes `details.adv` on mobile.

**Not safe / depends on mock data or unrelated features**
- `TOURS`, `DISCOUNT`, `INCLUDED`, `MONTHS`, the precomputed `hay` search string and `matches/sorted/matchDate/fillSelects/fillHotels` (client-side search replacing the server flow).
- `renderCatalog/renderTour/renderAdmin`, hash router (`#/tour/…`, `#/admin`), the demo role switch (`#roleBtn`, `state.isAdmin`) and the `#navAdmin` link — remove or replace with the project's real role logic.
- Booking form handler and its success message (no backend).
- Hard-coded content: all tour names/descriptions, hotels, transport strings, phone `+38 (044) 123-45-67`, `hello@obrii.example`, address, working hours, «Ліцензія та договір…» text, «Групи до 30 людей…», the 15% hot discount rule. Replace with real data or omit.
- Remote images in the reference (Unsplash/Pexels) belong to the mock tours; card/detail images must come from the project's data. The hero image may be kept as a purely decorative asset.
- Reference-only form controls without a PHP counterpart (e.g. «Враховувати» dep/arr/any, range vs. single date mode, hot-only checkbox, direction toggle) — implement **only** if the project's existing search already supports them; otherwise omit the control rather than adding backend features. Never remove an existing PHP control.

---

## 6. Acceptance checklist

**Structure**
- [ ] Header (logo + nav) present, sticky, translucent blur background, 1px bottom border.
- [ ] Hero present: image + gradient overlay, eyebrow, `h1`, lead, two buttons, bottom-left aligned.
- [ ] Search panel overlaps hero by 5.5rem, white, 18px radius, shadow.
- [ ] Catalog heading, count (`aria-live`), footnote only if a discount exists, sorter, empty-state block, 3-column grid.
- [ ] Steps band present (3 numbered items) or consciously omitted and noted.
- [ ] **Footer present** with 3 columns and `.legal` line.
- [ ] Details/admin views implemented only where the project has equivalent pages.

**Tokens & typography**
- [ ] All 6 colors and spacing/radius/container variables match §2.1 exactly.
- [ ] Cormorant Garamond for headings/logo/prices, Manrope for body; weights as listed; Cyrillic renders.
- [ ] H1–H4, body, small and button sizes match §2.2; line-heights 1.08 (headings) and 1.6 (body).

**Components**
- [ ] Buttons: pill radius, padding `.8rem 1.5rem`, three variants, hover/disabled states.
- [ ] Inputs: 46px min height, 12px radius, cream bg, 1.5px border, teal focus ring.
- [ ] Card: image 4:3, badge position, content order route → title → short → meta → hotels → footer; price/seat styles; hot price in `--c-hot`.
- [ ] Formats: `dd.mm.yyyy`, «1 290 €», Ukrainian plurals, `★` ratings with `aria-label`.
- [ ] Empty-state text is exactly `«На жаль, на Ваш запит інформація відсутня. Пропонуємо:»` followed by the full catalog.

**Responsive** (test 1280, 900, 375 px)
- [ ] Grid 3 → 2 (≤1020) → 1 (≤680); filters and dates 4 → 2 → 1; steps 3 → 1; footer 3 → 1.
- [ ] Nav wraps under the logo ≤680; sorter full-width ≤680; hero bottom padding 7rem ≤680.
- [ ] Advanced filters collapsed on load at ≤680 and open on desktop.
- [ ] No horizontal page scroll; wide tables scroll inside their wrapper.

**Accessibility & motion**
- [ ] Every control has a `<label>`; skip link works; focus ring visible; headings in order.
- [ ] `prefers-reduced-motion` disables all animation and nothing stays hidden; with JS disabled all content is visible.

**PHP functionality (no regressions)**
- [ ] Existing form `method`, `action`, field names, validation and sticky values unchanged.
- [ ] Every previously working search/filter/sort combination returns the same results as before the restyle.
- [ ] Reset/clear action restores the full catalog; empty search shows the message + full catalog.
- [ ] All tour data comes from `db.php`; no mock data from the reference appears in output.
- [ ] Output is escaped; links to tour details still work from each card.
