# TASK — Correct the TourKit Design Integration

## Objective

Correct the existing, incomplete visual integration so the TourKit PHP website follows `DESIGN-SPEC.md` and the verified original HTML reference while preserving the current application structure, real tour data, and existing search flow.

This is a **targeted correction task**. Do not redesign the site, rebuild it from scratch, or add unrelated functionality.

## Required inputs

Read these sources before planning:

- `AGENTS.md` — persistent project rules and workflow.
- `DESIGN-SPEC.md` — design requirements extracted from the reference.
- The original HTML reference. `DESIGN-SPEC.md` names `index.html` as its source, while its integration mapping also mentions `references/design-reference.html`.
- The current `index.php`, `countries.php`, `country.php`, `header.php`, `footer.php`, `db.php`, `css/style.css`, and `js/scripts.js` files, where present.

**Resolve the reference-file ambiguity first.** Locate the available candidate file(s) and verify which one matches the provided specification. If the intended original cannot be identified confidently, report the exact paths found and stop before proposing implementation changes. Never modify or overwrite a reference file.

## Sources of truth and conflict handling

- Existing PHP code is the source of truth for current page structure and application flow.
- `db.php` is the source of truth for tour data.
- The verified original HTML/CSS is the visual reference.
- `DESIGN-SPEC.md` provides detailed design values and section requirements.
- `AGENTS.md` defines persistent workflow and safety rules.

If the specification and the verified HTML disagree, list the exact conflict and recommend which value to use; do not silently guess. If the requested visual design conflicts with existing functionality or unavailable data, document the limitation and ask before expanding scope.

The reference is branded “Обрій”; the existing project is TourKit. Reuse the reference's visual system, layout, and component styling, but keep TourKit branding and project-specific copy. Do not copy fictional tours or mock contact details.

## Scope — visual corrections

Compare the current implementation against the reference and `DESIGN-SPEC.md`. The discrepancy report must explicitly assess each item below as **present**, **incomplete**, **missing**, or **not applicable**, with evidence from the current files.

1. **Header and navigation** — logo treatment, links, spacing, sticky appearance, phone visibility, and mobile menu behavior where supported.
2. **Hero** — restore the missing or incomplete Hero. Match the reference's two-column desktop layout, text hierarchy, chip, spacing, radius, shadow, image crop/fade, and mobile stacking. Do not invent factual claims or dates for TourKit.
3. **Search form** — match the reference's visual style, field alignment, sizes, gaps, and button treatment. Keep the existing form method, action, field names, and supported behavior; do not add controls that the PHP backend cannot support.
4. **Catalog/results and tour cards** — match available card structure, content hierarchy, image proportions (when real project images exist), padding, typography, borders, shadows, and grid behavior.
5. **Footer** — implement the missing or incomplete visual structure. Keep TourKit branding. Use contact information only if it exists in the project; otherwise report that real details are unavailable and do not invent or copy “Обрій” contacts.
6. **Global design system** — use the exact values from `DESIGN-SPEC.md` where applicable: colors, font families, type scale, container width, spacing tokens, radii, shadows, focus styles, and breakpoints.
7. **Responsive layout** — implement the documented breakpoints at 1060px, 820px, and 620px as appropriate for the existing PHP pages; avoid unintended horizontal overflow on a 360px viewport.
8. **Accessibility and motion** — retain meaningful labels, keyboard-visible focus, appropriate status announcements where compatible with the current flow, and reduced-motion behavior for animations that are retained.

## Optional reference sections — do not fabricate functionality

The specification lists popular destinations, hot offers, a details dialog/toast, and an admin dashboard as optional or data-dependent. Do not add these automatically just to imitate every part of the reference.

- **Popular destinations:** include only when each tile can map to an existing supported country/filter and can be represented without fabricated tour data or prices.
- **Hot offers:** include only if current data has a reliable hot/discount indicator and the necessary original-price data. Never infer a discount.
- **Details dialog, request form, and toast:** include only if the project has an actual usable data source and request handler. Never display a success message for a request that was not submitted.
- **Admin dashboard:** do not add the reference's mock dashboard to the public page. Restyle an existing admin page only if one exists and it is explicitly in scope.

For every omitted optional section, give a brief reason in the final report.

## Preserve existing PHP functionality and data

- Preserve the current PHP file structure, rendering flow, form `method`/`action`, parameter names, and GET/POST behavior.
- Preserve currently working filters and sorting. Do not change `countries.php`, `db.php`, filter rules, tour data, or business logic as part of this visual-only correction.
- Do not add fictional records, prices, old prices, hotel details, places-left counts, cities, dates, durations, or tour-card images.
- Render only fields that genuinely exist in the current data. If a reference component depends on missing data, omit that specific detail and report the limitation rather than fabricating a placeholder.
- Do not add search fields from the reference unless the current backend supports them.
- If inspection reveals a pre-existing functional bug or an issue introduced by the earlier integration, list it separately in the plan. Do not silently fix it under this visual task; ask for approval to expand the scope.
- When modifying PHP templates, escape dynamic output appropriately, e.g. `htmlspecialchars($value, ENT_QUOTES, 'UTF-8')`, but do not turn this task into unrelated security refactoring.
- Do not add frameworks, packages, databases, APIs, build tools, or paid services.

## Phase 1 — Plan only; no edits

Inspect the files and compare the current rendered structure/styles with the verified reference and specification. Do not edit files in this phase.

Produce a concise but specific discrepancy table with these columns:

| Requirement / reference selector | Current state and evidence | File(s) involved | Exact proposed correction | How to verify |
|---|---|---|---|---|

The table must explicitly cover the header, Hero, search form, catalog/cards, footer, design tokens, and responsive behavior. It must also identify optional sections to omit and why. Use actual selector names and exact measurements from `DESIGN-SPEC.md`; do not say only “improve spacing” or “make it responsive.”

Then provide a file-by-file implementation sequence that minimizes unnecessary edits. Distinguish visual changes from any pre-existing functional bugs or conflicts. Do not change files until the user explicitly approves the plan.

## Phase 2 — Implement only after approval

- Implement only the approved corrections.
- Prefer focused edits over replacing whole files.
- Keep the original reference and `DESIGN-SPEC.md` unchanged.
- Do not change filter logic, data, or other business behavior unless the user separately approves it.
- If a missing content value or behavior prevents faithful implementation, stop and report it rather than inventing a substitute.

## Acceptance criteria

- [ ] The reference-file ambiguity has been resolved and the original has remained unchanged.
- [ ] The Hero is present and its layout, typography, spacing, image treatment, and responsive behavior follow the verified reference where project content permits.
- [ ] Header/navigation and footer are complete; no fictional brand or contact details were copied.
- [ ] Global tokens, container width, spacing, typography, colors, radii, shadows, and card/grid layout follow the specification where applicable.
- [ ] The existing supported search fields, GET/POST flow, and working filters are preserved.
- [ ] No fictional tours, prices, tour attributes, or unsupported fields are introduced.
- [ ] Optional sections are included only where current data and functionality support them; omissions are documented.
- [ ] Responsive behavior is checked at the documented breakpoints and no unintended horizontal page overflow occurs at 360px.
- [ ] `DESIGN-SPEC.md` and the original HTML reference remain unchanged.
- [ ] The final report distinguishes checks actually performed from those not performed.

## Final report

After implementation, report:

1. Files changed and reason for each change.
2. Required sections/components completed.
3. Optional sections omitted and the reason for each.
4. Commands/tests actually performed and their results.
5. Remaining visual differences, unavailable data, or unverified behavior.
