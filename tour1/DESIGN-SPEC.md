# DESIGN-SPEC.md — турагенція «Обрій»

Source of truth: `references/design-reference.html` (single file, embedded CSS + vanilla JS, `lang="uk"`).
Goal: reproduce the **visual design** in an existing PHP project without losing its `db.php` data or GET/POST search flow.

> Everything below is extracted from the source. Values written as `var(--x)` exist as CSS custom properties. Values marked *(hard-coded)* are literals in the source, not tokens — keep them or promote them to tokens, but do not change them.

---

## 1. Page structure and section inventory

### 1.1 DOM order (body children)

| # | Element | Selector / id | Status | Notes |
|---|---|---|---|---|
| 0 | Skip link | `a.skip` → `#tours` | Mandatory | Off-screen until focused |
| 1 | Site wrapper | `div#site` | Mandatory | Hidden when `location.hash === '#admin'` |
| 1.1 | Header | `header.top` | **Mandatory** | Sticky |
| 1.2 | Main | `main#top` | Mandatory | Contains 1.2.1–1.2.5 |
| 1.2.1 | Hero | `.wrap > section.hero` | **Mandatory** | `style="padding:0"` inline (overrides global `section` padding) |
| 1.2.2 | Search form | `.wrap > form.search#heroForm` | **Mandatory** | Overlaps hero bottom by 56px |
| 1.2.3 | Popular destinations | `.wrap > .dest#dest` | Optional | 4 shortcut tiles; needs a country filter |
| 1.2.4 | Hot offers | `section#hot` | Optional | Needs a "hot / old price" field in data |
| 1.2.5 | Tour catalog | `section#tours` | **Mandatory** | Filter panel + result line + empty state + grid |
| 1.3 | Footer | `footer.foot#contacts` | **Mandatory** | Navigation + contacts |
| 2 | Admin dashboard | `div#admin.adm` | Optional (separate view) | Demo only, mock data |
| 3 | Tour details modal | `dialog#dlg` | Optional | Opened by "Детальніше" |
| 4 | Toast | `div#toast.toast` | Optional | Feedback after request form |

Hero, search form and destinations share one `.wrap` and are **not** separate `<section>` elements (only the hero is a `<section>`).

### 1.2 Section content

**Header** — logo `Обрі` + `<span>й</span>` (teal), `button.burger` "Меню" (mobile only), `nav#nav` with 3 links (`Каталог турів` → `#tours`, `Гарячі тури` → `#hot`, `Контакти` → `#contacts`), phone link `+38 (044) 123-45-67`, ghost small button `Панель адміністратора` → `#admin`.

**Hero** — two columns. Left: chip «Вильоти з листопада 2026 до березня 2027», `h1` «Тури за вашими датами, бюджетом і готелем», paragraph «Порівнюйте ціни, дивіться, скільки вільних місць залишилось, і одразу бачте, що входить у вартість. Греція, Мальдіви, Таїланд, ОАЕ, Туреччина та Швейцарія.» Right: photo `https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1400&q=75`, alt «Мальовничий краєвид для подорожі», 1400×933.

**Search form** (`role="search"`, `aria-label="Швидкий пошук туру"`) — 5 fields + submit:
1. «Назва туру чи напрямок» `type=search`, placeholder «Наприклад, Санторіні»
2. «Країна» `select` (first option «Усі країни»)
3. «Виліт від» `type=date`
4. «Виліт до» `type=date`
5. «Ціна до, €» `type=number min=0 step=50 inputmode=numeric`, placeholder `2000`
6. Button `.btn.btn--primary` «Знайти тур»

**Popular destinations** — 4 `button` tiles (Греція, Мальдіви, Таїланд, Швейцарія), each: photo, name left, «від N €» right. Click = filter by country and scroll to `#tours`.

**Hot offers** — `.sec-head` (h2 «Гарячі тури зі знижками», p «Вільних місць небагато, а ціна нижча за стандартну. Знижку вже враховано.», ghost-small button «Показати у каталозі») + horizontal scroller `.hot#hotList` of the same `.card` component (only tours with `hot`, sorted by discount desc).

**Tour catalog** — `.sec-head` (h2 «Каталог турів», p «Фільтруйте за напрямком, готелем, ціною та датою вильоту. Результати оновлюються одразу.») → `form.panel` → `p.result-line` → `.empty` (conditional) → `.grid`.
Filter panel fields (in order): «Назва туру чи напрямок», «Країна», «Місто» (datalist), «Готель» (datalist), «Ціна від, €», «Ціна до, €», «Точна дата вильоту», «Діапазон дат вильоту» (two date inputs, aria-labels «Виліт від» / «Виліт до»). Second row: checkbox toggle «Лише гарячі тури»; «Сортувати» select; ghost-small button «Скинути фільтри».
Sort options (value → label): `date-asc` За датою вильоту: найближчі · `date-desc` …найдальші · `price-asc` За ціною: від найнижчої · `price-desc` …від найвищої · `dur-asc` За тривалістю: коротші · `dur-desc` …довші · `name-asc` За назвою: А → Я · `name-desc` Я → А.

**Result line** (`role="status" aria-live="polite"`): «Знайдено N турів із M.» or, when empty, «Збігів немає. Нижче весь каталог: M турів.»

**Empty state** (required text, exact): **«На жаль, на Ваш запит інформація відсутня. Пропонуємо:»** + primary-small button «Скинути фільтри». The **full catalog grid is rendered directly below it**.

**Footer** — 3 columns: brand (logo + «Турагенція в Києві. Підбираємо тури з вильотом з Варшави, Кракова, Кишинева та автобусні подорожі зі Львова.»), «Навігація» (Каталог турів, Гарячі тури, Панель адміністратора), «Контакти» (phone, email `hello@obriy.travel`, «м. Київ, вул. Хрещатик, 22, офіс 14», «Пн–Пт 10:00–19:00, Сб 11:00–16:00»). Bottom `<small>`: «Ціни вказано в євро за одну особу при двомісному розміщенні. Остаточну вартість підтверджує менеджер.» Contact values are mock — replace with the project's real data.

**Admin dashboard** (optional, separate view) — dark bar, note banner, 4 KPI cards (Вільних місць, Вартість вільних місць, Продано місць, Вартість проданих місць), table «Місця за турами» (7 columns), «Продажі за країнами» progress list. Demo only.

---

## 2. Design tokens

### 2.1 CSS custom properties (`:root`, verbatim)

```css
:root{
  --c-deep:#0b3a4a;  --c-teal:#13869b;  --c-aqua:#e4f3f5;
  --c-bg:#f5fafb;    --c-ink:#18303a;   --c-hot:#d9472b;

  --ff-head:"Onest","Segoe UI",system-ui,sans-serif;
  --ff-body:"Manrope","Segoe UI",system-ui,sans-serif;

  --fs-h1:clamp(2.1rem,4.4vw,3.4rem);
  --fs-h2:clamp(1.6rem,3vw,2.3rem);
  --fs-h3:1.25rem;  --fs-h4:1.05rem;
  --fs-body:1rem;   --fs-small:.86rem;  --fs-btn:.95rem;

  --sp-1:.5rem; --sp-2:1rem; --sp-3:1.5rem; --sp-4:2.5rem; --sp-5:4.5rem;
  --r-sm:10px;  --r-md:16px; --r-lg:28px;
  --shadow:0 10px 30px -12px rgba(11,58,74,.28);
  --w:1200px;
}
```

Fonts (Google Fonts, Cyrillic): `Manrope:wght@400;500;600;700` and `Onest:wght@500;600;700;800`, `display=swap`, `subset=cyrillic`.

### 2.2 Hard-coded colors (not tokens)

| Value | Use |
|---|---|
| `#fff` | cards, header base, panels, inputs, hero background |
| `rgba(255,255,255,.92)` + `backdrop-filter:blur(10px)` | header background |
| `#dcebee` | borders (header, panel, search), bar tracks, card bottom edge |
| `#bdd6db` | input/select/toggle border |
| `#e3eef0` | dividers (facts block, table rows) |
| `#3d5a64` | secondary text (section intro, card description) |
| `#5d7a84` | muted text (dt labels, "за особу", table head) |
| `#7a8f96` | old (struck-through) price |
| `#e0a100` | hotel stars |
| `#fdeeea` | checked "hot" toggle background |
| `#d3e8ec` | footer text |
| `rgba(5,30,40,.78)` → transparent at 60% | destination tile overlay gradient (`to top`) |
| `rgba(5,30,40,.55)` | dialog backdrop |
| `#eaf2f4` | admin page background |

### 2.3 Typography

| Element | Family | Size | Weight | Line-height | Other |
|---|---|---|---|---|---|
| body | `--ff-body` | `--fs-body` 1rem | 400 | 1.6 | color `--c-ink`, bg `--c-bg`, antialiased |
| h1 | `--ff-head` | `--fs-h1` | 800 | 1.15 | color `--c-deep`, letter-spacing -.01em |
| h2 | `--ff-head` | `--fs-h2` | 700 | 1.15 | same |
| h3 | `--ff-head` | `--fs-h3` 1.25rem | 700 | 1.15 | same |
| h4 | `--ff-head` | `--fs-h4` 1.05rem | 600 | 1.15 | same |
| `.btn` | `--ff-body` | `--fs-btn` .95rem (`.btn--sm`: .88rem) | 600 | 1 | |
| `.logo` | `--ff-head` | 1.5rem | 800 | — | letter-spacing -.02em |
| field label | body | `--fs-small` | 600 | — | color `--c-deep` |
| field input/select | body | .95rem | 500 | — | color `--c-ink` |
| nav link | body | .95rem | 600 | — | |
| price (card) | `--ff-head` | 1.5rem | 800 | 1 | color `--c-deep` |

### 2.4 Layout constants

- Container `.wrap`: `width:min(100% - 2rem, var(--w)); margin-inline:auto` (max 1200px, 1rem side gutter).
- Global `section{padding-block:var(--sp-5) 0}` (4.5rem top, 0 bottom). The hero overrides this inline with `padding:0`.
- `html{scroll-behavior:smooth; scroll-padding-top:84px}` (compensates sticky header).
- Focus: `:focus-visible{outline:3px solid var(--c-teal); outline-offset:2px; border-radius:6px}`.
- `[hidden]{display:none!important}`.
- Box-sizing `border-box`, `margin:0` on all elements; `img{max-width:100%; display:block}`.

### 2.5 Breakpoints (all `max-width`)

`1060px`, `820px`, `620px`. Plus `@media (hover:hover)` (hover lifts) and `@media (prefers-reduced-motion:reduce)`.

---

## 3. Component specifications

### 3.1 Buttons (`.btn`)
`inline-flex`, centered, gap .5rem, padding `.9rem 1.4rem`, radius 999px, `2px solid transparent`, cursor pointer.
- `--primary`: bg `--c-teal`, text `#fff`; hover bg `--c-deep`.
- `--ghost`: border `--c-teal`, text `--c-teal`, transparent; hover bg `--c-teal`, text `#fff`.
- `--sm`: padding `.65rem 1.05rem`, font-size .88rem.
- Transition: background/color/border `.2s`, transform `.2s`, box-shadow `.2s`. `:active` → `scale(.98)`. Hover (hover-capable only): `translateY(-1px)` + `box-shadow:0 8px 16px -8px rgba(11,58,74,.5)`.

### 3.2 Header (`header.top`, `.top__in`)
- `position:sticky; top:0; z-index:50`; bg `rgba(255,255,255,.92)`, blur 10px, `border-bottom:1px solid #dcebee`. After 8px scroll, class `.scrolled` adds `box-shadow:0 8px 22px -14px rgba(11,58,74,.4)`.
- Inner: `.wrap` flex, `align-items:center`, `gap:var(--sp-3)`, `min-height:68px`.
- Logo: `margin-right:auto` (pushes everything else right), no underline.
- Nav: flex, gap `--sp-3`, links `padding:.4rem 0`; hover/focus underline = `::after` 2px `--c-teal`, `scaleX(0→1)` from left, `.25s`.
- Phone: weight 700, `white-space:nowrap`; hover color `--c-teal`.
- Burger: hidden on desktop (`display:none`).

### 3.3 Hero (`section.hero`)
- `margin-top:var(--sp-3)`; `display:grid; grid-template-columns:minmax(0,5fr) minmax(0,6fr)`; bg `#fff`; radius `--r-lg`; `overflow:hidden`; `box-shadow:var(--shadow)`.
- Text column `.hero__text`: padding `clamp(1.5rem,4vw,3.5rem)`; flex column, `justify-content:center`, gap `--sp-2`; `position:relative; z-index:1`. Paragraph: `max-width:46ch; font-size:1.08rem`.
- Chip `.chip`: `align-self:flex-start`; bg `--c-aqua`; color `--c-deep`; weight 600; size `--fs-small`; padding `.35rem .85rem`; radius 999px.
- Image column `.hero__img`: `position:relative; min-height:380px`; `img` is `position:absolute; inset:0; width/height:100%; object-fit:cover` with `mask-image:linear-gradient(to right, transparent 0, #000 28%)` (with `-webkit-` prefix) so the photo fades into the white text panel.
- Load animation: text children `rise .7s` staggered 0 / .1s / .2s; image `heroImg 1.4s ease-out` (opacity 0 + scale 1.05 → normal).

### 3.4 Search form (`form.search`)
- `position:relative; z-index:2`; margin `-56px clamp(.5rem,3vw,2.5rem) 0`; bg `#fff`; radius `--r-md`; shadow `--shadow`; padding `--sp-3`; border `1px solid #dcebee`.
- `display:grid; grid-template-columns:2fr 1.3fr 1fr 1fr 1fr auto; gap:var(--sp-2); align-items:end`.
- `.field`: flex column, gap `.3rem`, `min-width:0`. Label above input.
- Input/select: width 100%, `min-height:46px`, padding `.72rem .8rem`, border `1.5px solid #bdd6db`, radius `--r-sm`, bg `#fff`. Hover border `--c-teal` (hover-capable). Focus: border `--c-teal` + `box-shadow:0 0 0 3px rgba(19,134,155,.18)`.

### 3.5 Popular destinations (`.dest`)
- `grid; grid-template-columns:repeat(4,1fr); gap:var(--sp-2); margin-top:var(--sp-3)`.
- Tile `button`: `aspect-ratio:16/10`, radius `--r-md`, `overflow:hidden`, no border/padding, bg `--c-deep`, color `#fff`, text-align left. Image absolute cover; `::after` gradient overlay; label `span` absolute `left/right:.9rem; bottom:.7rem`, flex space-between baseline, weight 700; `small` weight 600, .8rem. Image hover `scale(1.045)` (`.7s`).

### 3.6 Section header (`.sec-head`)
Flex, `justify-content:space-between; align-items:end; gap:var(--sp-2); flex-wrap:wrap; margin-bottom:var(--sp-3)`. Paragraph: `max-width:56ch; margin-top:.4rem; color:#3d5a64`.

### 3.7 Hot offers scroller (`.hot`)
`display:grid; grid-auto-flow:column; grid-auto-columns:minmax(290px,340px); gap:var(--sp-2); overflow-x:auto; padding:.3rem .2rem 1rem; scroll-snap-type:x mandatory`; cards `scroll-snap-align:start`; `tabindex="0"` + `aria-label` for keyboard scroll.

### 3.8 Filter panel (`form.panel`)
- bg `#fff`; border `1px solid #dcebee`; radius `--r-md`; padding `--sp-3`; `display:grid; gap:var(--sp-2)`.
- `.panel__grid`: `grid-template-columns:repeat(4,1fr); gap:var(--sp-2)` (8 fields → 2 rows). Date-range field: inner grid `1fr 1fr`, gap `.4rem`.
- `.panel__row`: flex, wrap, gap `--sp-2`, `justify-content:space-between; align-items:end`. Sort field `min-width:230px`.
- `.toggle`: `inline-flex`, gap `.5rem`, weight 600, padding `.5rem .9rem`, border `1.5px solid #bdd6db`, radius 999px, bg `#fff`; checkbox `accent-color:var(--c-hot)`, 1.05rem; `:has(input:checked)` → border `--c-hot`, bg `#fdeeea`.
- `.result-line`: margin `--sp-3 0 --sp-2`, weight 600, color `--c-deep`.

### 3.9 Empty state (`.empty`)
bg `#fff`; `border:1.5px dashed var(--c-teal)`; radius `--r-md`; padding `--sp-3`; margin-bottom `--sp-3`; flex, gap `--sp-2`, `align-items:center; justify-content:space-between; flex-wrap:wrap`. Text: `--ff-head`, 1.15rem, weight 700, color `--c-deep`.

### 3.10 Tour card (`article.card`)
- Container: bg `#fff`, radius `--r-md`, `overflow:hidden`, flex column, `box-shadow:0 2px 0 #dcebee, var(--shadow)`.
- Grid `.grid`: `repeat(3,1fr)`, gap `--sp-3`.
- **Image** `.card__img`: `aspect-ratio:4/3`, bg `--c-aqua`, `overflow:hidden`; `img` width/height 100%, `object-fit:cover`, `loading="lazy"`, 900×675 attributes, descriptive `alt`.
- **Hot badge** `.badge` (only if hot): absolute `left:.8rem; top:.8rem`; bg `--c-hot`; white; weight 700; .82rem; padding `.35rem .7rem`; pill. Text: «Гарячий тур −N%» where N = `round((1 − price/oldPrice)·100)`.
- **Body** `.card__body`: padding `var(--sp-2) var(--sp-3) var(--sp-3)` (1rem 1.5rem 1.5rem); flex column; gap `.7rem`; `flex:1`.
- **Content order (top → bottom):**
  1. Place line `.card__place`: «Країна, місто[, місто]» — `--fs-small`, weight 600, color `--c-teal`.
  2. `h3` tour name.
  3. Description `.card__desc`: .92rem, color `#3d5a64`, clamped to 3 lines (`-webkit-line-clamp:3`).
  4. Facts `dl.facts`: 2-col grid, gap `.55rem 1rem`, .88rem, `border-block:1px solid #e3eef0`, padding-block `.8rem`. `dt` .76rem `#5d7a84`; `dd` margin 0, weight 600. Items: Виліт, Прибуття (dates `д місяць рік`, uk-UA), Тривалість («N ніч/ночі/ночей»), Транспорт, Готель (full row `.wide`: name + `★`×stars, color `#e0a100`, letter-spacing `.06em`, `role="img"` `aria-label="N-зірковий готель"`).
  5. Places `.places`: .86rem, «Вільно **N** місце/місця/місць із M»; `<b>` color `--c-deep`. When `left ≤ 5` → modifier `--low` (`<b>` and bar fill use `--c-hot`). Bar: height 6px, radius 9px, track `#dcebee`, fill `--c-teal` width = sold share %.
  6. Footer `.card__foot` (`margin-top:auto`, flex, space-between, `align-items:end`, gap `.5rem`): left price block (old price `.old` .9rem/600/`#7a8f96`/line-through, then price, then `small` «за особу» .78rem `#5d7a84`); right `.btn.btn--primary.btn--sm` «Детальніше».
- Price format: `Intl.NumberFormat('uk-UA')` + « €» (e.g. `1 290 €`).
- Hover (hover-capable): `translateY(-4px)`, shadow `0 2px 0 #dcebee, 0 20px 38px -16px rgba(11,58,74,.4)`, image `scale(1.045)`; transition `.3s` / image `.7s`.

### 3.11 Details dialog (`dialog#dlg`)
Width `min(94vw,760px)`, `max-height:92vh`, `overflow:auto`, padding 0, radius `--r-lg`, no border. Image `aspect-ratio:16/7`. Content padding `--sp-3`, grid gap `--sp-2`. Two columns (`1fr 1fr`, gap `--sp-3`): facts list + request form (bg `--c-aqua`, padding `--sp-2`, radius `--r-md`; fields: Ім'я, Телефон, Кількість мандрівників; primary submit «Надіслати заявку»). Close button: 42×42 white circle, absolute `right/top:.8rem`, `×`.

### 3.12 Toast
Fixed, `left:50%; bottom:1.5rem; transform:translateX(-50%)`, bg `--c-deep`, white, padding `.9rem 1.3rem`, radius `--r-md`, shadow, z-index 200, auto-hide 5s, `role="status"`.

### 3.13 Footer (`footer.foot`)
`margin-top:var(--sp-5)`; bg `--c-deep`; color `#d3e8ec`; padding-block `--sp-4`. Grid `1.4fr 1fr 1.2fr`, gap `--sp-4`. `h4` white, margin-bottom `.7rem`. Lists: no bullets, grid gap `.4rem`. Logo white, `display:inline-block; margin-bottom:.6rem`. Links: no visible underline; hover underline fades in (`text-decoration-color` transition `.25s`). Disclaimer `<small>`: `display:block; margin-top:var(--sp-3); opacity:.75`.

### 3.14 Admin dashboard (`#admin.adm`) — demo only
bg `#eaf2f4`, `min-height:100vh`. Top bar bg `--c-deep` (min-height 64px, tag pill `rgba(255,255,255,.15)`, "← Повернутися на сайт" white ghost button). Body `.adm__body`: padding-block `--sp-4 --sp-5`, grid gap `--sp-3`. `.note`: white, `border-left:4px solid --c-teal`. KPIs: 4 columns gap `--sp-2`; `.kpi` white, radius `--r-md`, padding `--sp-3`, shadow; label .88rem/600/`#5d7a84`; value `--ff-head` 800 `clamp(1.5rem,2.6vw,2.1rem)` `--c-deep` ("sold" cards value `--c-teal`). Columns `2.2fr 1fr`, gap `--sp-3`. `.box`: white, radius `--r-md`, padding `--sp-3`, shadow. Table: `min-width:640px`, th .78rem `#5d7a84`, cells padding `.7rem .6rem`, numeric cells right-aligned tabular-nums; progress `.mini` 6px (10px in country list).

### 3.15 Motion
Keyframes: `rise` (opacity 0 + `translateY(16px)`), `fade`, `heroImg`, `grow` (`scaleX(0)` from left), `dlgIn`, `toastIn`. Only `transform` and `opacity` animate.
- Scroll reveal: `.js :is(.search,.dest,.sec-head,.panel,.hot,.foot__grid)` start `opacity:0; translateY(18px)`; class `.in` added once by `IntersectionObserver` (threshold .12, rootMargin `0 0 -40px 0`); transition `.6s`. Requires `<script>document.documentElement.classList.add('js')</script>` in `<head>`.
- Grid cards: `rise .5s backwards`, delay 0 / .06s / .12s by `nth-child(3n+…)`; `.grid.still` disables it when the result set is unchanged.
- Mobile nav open/close: opacity + `translateY(-8px)` + visibility, `.25s`.
- `prefers-reduced-motion: reduce`: all `animation`/`transition` disabled, reveal elements forced visible.

---

## 4. Responsive behavior

| Breakpoint | Changes (exactly as in CSS) |
|---|---|
| **> 1060px** | Search: 6 tracks. Destinations: 4 cols. Catalog grid: 3 cols. Filter panel: 4 cols. Admin KPIs: 4 cols; admin columns 2.2fr/1fr. |
| **≤ 1060px** | Search: `repeat 3` (`1fr 1fr 1fr`), submit button `grid-column:1/-1`. Grid: 2 cols. Panel: 2 cols. Destinations: 2 cols. KPIs: 2 cols. Admin columns: 1 col. |
| **≤ 820px** | Burger visible; `.top__phone` hidden; nav becomes an absolute dropdown (`top:68px; left/right:0`, white, column, padding `1rem 1rem 1.5rem`, bottom border), closed by default (opacity 0, hidden), opens with `.open`; `aria-expanded` toggled; closes on link click. Hero: 1 col, image **first** (`order:-1`, `min-height:240px`), mask direction changes to `linear-gradient(to bottom, #000 60%, transparent)`. Footer grid: 1 col. Dialog columns: 1 col. |
| **≤ 620px** | Search: 2 cols, first field spans both, side margin `.4rem`. Catalog grid and filter panel: 1 col. KPIs: 2 cols. Destinations: 2 cols. |

Notes: the header admin button stays visible at all widths (no rule hides it). Hot scroller keeps horizontal scroll at all widths. Hover effects exist only under `(hover:hover)`, so touch devices get none.

---

## 5. PHP integration mapping

> The original project's template filenames are **not known from the source**. Only `db.php` and the GET/POST search flow are given. Map by **role**; the agent must locate the real files and confirm before editing.

### 5.1 Section → PHP template role

| Design section | Target in PHP project | Visual vs. functional |
|---|---|---|
| Skip link, `<head>` (fonts, `js` flag script, CSS) | Shared layout / header include | Visual only |
| `header.top` + burger + nav | Shared header partial | Visual; links must point to the project's real URLs/anchors |
| Hero | Search/home page template | Visual only (static copy) |
| `form.search` | The page that already contains the search form | **Restyle the existing form**; keep its `method`, `action`, field names, and handling |
| `.dest` (optional) | Home/search template | Only if each tile can link to an existing GET filter (e.g. `?country=…`) |
| `section#hot` (optional) | Home/search template | Only if `db.php` has a hot/discount indicator and old price; otherwise omit |
| `section#tours` filter panel | Same template as the search form | Restyle existing filters; add only controls the backend already supports |
| Result line, empty state, `.grid` + `.card` | Results/catalog template (the loop over `db.php` tours) | Server-rendered with PHP |
| `footer.foot` | Shared footer partial | Visual; replace mock contacts with real ones |
| Dialog, toast (optional) | Optional enhancement | Needs a real handler; do not fake submission |
| Admin dashboard (optional) | Existing admin page, if any | Visual restyle only; **not functional** in the source |

### 5.2 Hard rules
1. **Data**: render tours only from the project's `db.php` data. **Do not import** the `TOURS` array, tour names, hotel names, prices, images, or counts from the reference.
2. **Field mapping**: map each card element to the equivalent existing field (name, description, country, city/cities, departure date, arrival date, duration, transport, hotel, stars, price, old price/hot flag, places left/total). **If a field does not exist, omit that element** — do not invent data or placeholders. Duration in the reference is derived (`arrival − departure`, in nights); compute it in PHP only if dates exist.
3. **Search flow**: keep the existing GET/POST method, `action`, input `name`/`id` values, validation, and sort handling. The reference's `data-f` names (`q, country, city, hotel, min, max, date, from, to`) and sort values (`date-asc` …) are **suggestions only** and must not rename existing parameters. Add a design control only if the backend supports it.
4. **Two forms**: the reference duplicates 5 fields (hero form + filter panel) and syncs them with JS. In PHP use **one submit target**; either keep a single form styled as the design's search bar + panel, or two forms posting to the same endpoint. Do not carry over the JS mirroring unless needed.
5. **Empty results**: when the query returns zero rows, output exactly «На жаль, на Ваш запит інформація відсутня. Пропонуємо:» and then render the **full catalog** from `db.php` below it.
6. **Escape all output** (`htmlspecialchars`) as the reference does with `esc()`; keep Ukrainian plural logic (ніч/ночі/ночей; місце/місця/місць; тур/тури/турів) and `uk-UA` date/number formatting (use `IntlDateFormatter`/`NumberFormatter` or equivalents).
7. Preserve selected values after submit (inputs, selects, checkbox) so filters stay visible after a page reload.

### 5.3 Safe to reuse vs. not

**Safe to reuse as-is (no mock-data dependency):**
- The entire stylesheet: tokens, `.btn`, `.field`, `.card`, `.grid`, `.panel`, `.empty`, `.foot`, `.top`, `.hero`, `.search`, responsive rules, animations, reduced-motion rules.
- Markup patterns for header/nav, hero, search form, card, empty state, footer.
- JS: mobile nav toggle, header `.scrolled` toggle, `IntersectionObserver` reveal, `plural`/`esc`/`money`/`fdate` helpers (as PHP equivalents), dialog open/close and toast pattern (only if a real handler exists).

**Depends on mock data or unrelated features — do not port:**
- `TOURS` array, `U()` Unsplash image helper and all Unsplash tour image IDs.
- Client-side `matches()`, `sorted()`, `render()`, `state` — replaced by PHP query/sort.
- Derived datalists (cities, hotels), country `<select>` population, `featured` destinations list, hot list generation.
- Hero chip text «Вильоти з листопада 2026 до березня 2027», hero paragraph country list, footer address/phone/email, brand name «Обрій» — replace with the project's real content.
- `renderAdmin()`, `#admin` hash router, KPI/table/country-share data (mock; "демонстрація").
- Request-form submit → toast (no backend exists).
- `.still` result-signature logic (only meaningful with client-side re-rendering; drop it for server-rendered pages, or keep the `.grid` entrance animation without it).

---

## 6. Acceptance checklist

**Structure**
- [ ] Skip link, header, hero, search form, catalog (panel + result line + grid), footer all present, in the DOM order of §1.1.
- [ ] Optional sections (destinations, hot offers, details dialog, admin) are either implemented per §3 or deliberately omitted with a reason noted.
- [ ] **Header is implemented** (sticky, logo, nav, phone, burger on mobile).
- [ ] **Footer is implemented** (3 columns, disclaimer line, real contacts).

**Tokens and typography**
- [ ] All 6 colors, both font families, font sizes (h1–h4, body, small, button), spacing (`--sp-1…5`), radii (10/16/28), shadow and `--w:1200px` match §2.1 exactly.
- [ ] Onest used for headings, logo, price; Manrope for everything else; Cyrillic renders correctly.
- [ ] Hard-coded greys/borders from §2.2 are used where listed.

**Components**
- [ ] Hero: 5fr/6fr grid, radius 28, image fades into the text panel via mask, `min-height:380px`.
- [ ] Search form overlaps hero by `-56px`, 6-track grid `2fr 1.3fr 1fr 1fr 1fr auto`, gap 1rem, inputs 46px min-height, radius 10.
- [ ] Card: 4/3 image, place → title → 3-line description → facts → places bar → price + button; hot badge and discount only when applicable; low-places state at ≤5.
- [ ] Grid: 3 / 2 / 1 columns at >1060 / ≤1060 / ≤620.
- [ ] Empty state shows the exact Ukrainian sentence and the full catalog below it.
- [ ] Footer: columns `1.4fr 1fr 1.2fr`, stacked at ≤820.

**Responsive**
- [ ] ≤1060: search 3 cols with full-width button; panel/destinations 2 cols.
- [ ] ≤820: burger menu works (open/close, `aria-expanded`), phone hidden, hero stacked with image first and vertical mask.
- [ ] ≤620: search 2 cols with first field spanning; panel 1 col; grid 1 col.
- [ ] No horizontal page scroll at 360px (only the hot scroller and wide tables scroll internally).

**Behavior and accessibility**
- [ ] `lang="uk"`, labels on every field, `role="search"`, `aria-live` on result line, visible focus outline (3px `--c-teal`).
- [ ] Animations use only transform/opacity; `prefers-reduced-motion` disables them; content stays visible without JS.

**PHP**
- [ ] Tours come exclusively from `db.php`; no reference tour data present.
- [ ] Existing GET/POST search works exactly as before: same method, action, parameter names, validation, sorting, and preserved values.
- [ ] Every search/filter that worked before still works; zero-result query shows the empty-state message plus full catalog.
- [ ] All dynamic output escaped; plurals and uk-UA formatting preserved.
