# TourKit — Instructions for AI Coding Agents

## 1. Project overview

TourKit is a Ukrainian-language travel-agency website built with PHP, HTML, CSS, and vanilla JavaScript. Its existing PHP files and data structure are the starting point; do not replace the project with a new implementation.

## 2. Sources of truth

Use these sources in this order for the relevant concern:

- **Existing PHP code** — current application structure, routing, and form behavior.
- **`db.php`** — source of truth for available tour data. Do not import fictional tours from a design reference.
- **`references/design-reference.html`** — read-only visual reference. Never edit or overwrite it.
- **`DESIGN-SPEC.md`** — detailed design requirements extracted from the reference. If it is missing or conflicts with the reference, report the gap instead of inventing design values.
- **`TASK.md`** — the objective and scope of the current task.

The design reference may use the fictional brand name “Обрій”, while the existing project is TourKit. Reuse its visual design, not its fictional brand text or tour data, unless the current task explicitly says otherwise. Keep the site's existing TourKit identity and relevant Ukrainian content.

## 3. Project constraints

- Preserve the existing PHP architecture and file names.
- Preserve the form's GET/POST parameter names and the existing search flow unless the task explicitly authorizes a bug fix.
- Keep tour data in `db.php`; do not create substitute or invented records.
- Do not add a database, API, framework, package, build system, or paid service unless explicitly requested.
- Do not rewrite the project from scratch.
- Do not edit `references/design-reference.html` or silently replace existing working behavior.
- Keep all user-facing website text in Ukrainian unless the task specifies otherwise.
- Prefer minimal, focused changes over unrelated refactoring.

## 4. Required workflow

For a task affecting multiple files or changing layout or behavior:

1. Read `TASK.md` and `DESIGN-SPEC.md`, then inspect the relevant existing files and the read-only reference.
2. Compare the current implementation with the requested result. Do not assume that a section or behavior is present merely because an earlier plan mentioned it.
3. In **Plan** mode, provide a concise gap analysis and a file-by-file plan. Do not edit application files in the planning stage.
4. Wait for the user's explicit approval before implementing the plan.
5. In **Code** mode, implement only the approved scope. If an unexpected issue requires extra files or a change in scope, explain it and ask before proceeding.
6. After implementation, report modified files, tests actually run, results, and anything that remains unverified.

This workflow is an instruction for the agent; actual tool permissions are controlled separately in Kilo Code settings.

## 5. PHP and security

- Validate and normalize incoming `GET` and `POST` values before using them in filtering or control flow.
- Escape dynamic values rendered into HTML with `htmlspecialchars($value, ENT_QUOTES, 'UTF-8')` or an equivalent context-appropriate method.
- Avoid undefined-index notices; use safe defaults where appropriate.
- Do not claim that PHP syntax, filtering, or browser behavior was tested unless the relevant check was actually run.
- Do not run destructive shell commands or access files outside the project without explicit permission.

## 6. Design fidelity

When implementing the design:

- Use the actual HTML/CSS reference and `DESIGN-SPEC.md` rather than approximating from memory.
- Preserve the specified section order and implement every required section, including the Hero and footer when listed in the specification.
- Match the available design tokens, container widths, spacing, typography, colors, card proportions, grid, borders, and shadows.
- Reuse exact CSS values when available; do not invent replacements for values that can be extracted from the reference.
- Follow the documented responsive breakpoints and layout changes.
- Do not remove a section simply because its data or styling is inconvenient. If a section requires unavailable data, preserve its visual role only if the task allows it, and clearly report the limitation.
- Keep visual changes separate from data or business-logic changes wherever practical.

## 7. Character Encoding and Localization

- Save all HTML, PHP, CSS, JavaScript, and Markdown source files as UTF-8.
- Preserve existing Ukrainian text and Unicode characters exactly unless translation or text editing is explicitly requested.
- Do not replace, transliterate, or regenerate Ukrainian text when making unrelated code changes.
- Keep the HTML document language set to `uk` and ensure the document declares UTF-8 using `<meta charset="UTF-8">`.
- When modifying PHP templates, preserve correct UTF-8 output and do not introduce conflicting response charset headers.
- Avoid shell commands or file-writing methods that may convert text to the system's default encoding.
- After editing files containing Ukrainian text, inspect the diff and verify that the text remains readable.
- If encoding corruption is detected, stop and report it. Do not attempt a blind conversion or overwrite the original content.

## 8. Verification and final report

At the end of implementation:

- Check PHP syntax for changed PHP files if PHP CLI is available.
- Check form submission, parameter passing, and the existing filters if those areas were touched.
- Check empty-result and invalid-input behavior if relevant.
- Inspect the rendered page at desktop, tablet, and mobile widths if browser access is available.
- Compare the page against the original reference; if no browser/screenshot tool was available, state that visual verification remains manual.
- List changed files, explain material changes, identify tests performed, and state any remaining discrepancies.
