# AGENTS.md — Persistent Instructions for AI Coding Agents

> **Draft:** These instructions are based on the project brief and design specification. Before treating them as authoritative, inspect the existing repository and verify every project-specific assumption against the actual code.

## 1. Project Purpose

Maintain and improve the existing **TourKit** travel agency website. The application presents a public catalog of tours. Tour-detail and administrator financial-report views are not part of the current project; do not create them.

The primary goal is to improve the interface while preserving existing application behavior. This is an existing project: prefer small, focused changes over rewrites.

## 2. Technology Stack and Repository Awareness

- The project brief describes an existing **PHP application** with `db.php` used for tour data or existing data-access functions.
- Use the repository's actual HTML templates, CSS, JavaScript, PHP handlers, routes, and data-access patterns. Their exact file names and organization must be discovered from the repository; do not assume files or directories exist merely because they are mentioned in a brief.
- Use HTML for semantic structure, CSS for presentation and responsive behavior, JavaScript for appropriate progressive enhancement, and the existing PHP/backend for data retrieval and request handling.
- Do not replace the existing backend with a new implementation or introduce a new framework without explicit authorization.
- Do not assume a particular database engine, PHP version, package manager, build system, test framework, or deployment setup until confirmed from repository files.

## 3. General Coding Practices

- Inspect relevant files and current behavior before editing. Identify the existing implementation and extend it rather than duplicating it.
- Follow established project conventions for naming, indentation, file organization, routing, templates, and styling wherever practical.
- Keep changes focused, readable, maintainable, and proportionate to the task.
- Separate presentation from business logic. Prefer existing shared templates/partials and reusable styles when the project already uses them.
- Avoid duplicating markup, business rules, calculations, or styles unnecessarily.
- Do not perform broad refactors or rename/move files unrelated to the requested work.
- Preserve existing URLs, links, form field names, form methods and actions, request parameters, validation, session behavior, and role checks unless a change is explicitly required and approved.
- Do not add placeholder controls that look functional but have no working behavior.
- Do not silently remove an existing feature because it is not represented in a design reference.
- Comment code when the reason for a non-obvious decision needs explanation; avoid comments that merely repeat the code.
- Do not commit secrets, credentials, private configuration, or production data.

## 4. Language, Text, and Encoding

- **All user-facing interface text must be in Ukrainian**, unless the existing project explicitly requires a different language for a particular element.
- Preserve Ukrainian letters and punctuation exactly. Do not transliterate Ukrainian text or replace it with mojibake, escaped-looking corruption, or Russian-language copy.
- Use **UTF-8 encoding** for source files and text content. Preserve the existing encoding consistently and avoid introducing a byte-order mark unless the project already requires one.
- HTML pages should declare Ukrainian as the document language with `lang="uk"` where applicable.
- Ensure Ukrainian/Cyrillic characters render correctly in templates, forms, tables, validation messages, and dynamically generated content.
- Keep visible labels, button text, messages, dates, currency, and plural forms consistent with the project’s Ukrainian-language design specification.
- When editing text files, verify the saved output contains intact Ukrainian characters.

## 5. Data Integrity and Backend Boundaries

- Use the existing backend and data-access layer as the source of truth for tour data. Use `db.php` or existing data functions according to the actual project implementation.
- Do not substitute hard-coded demo tours or design-reference mock data for live project data.
- Do not move server-side search, filtering, sorting, calculations, or role-sensitive operations into client-side JavaScript when they are currently handled by PHP/backend logic.
- Preserve existing search and sorting behavior, including supported request parameters and combinations.
- Keep calculated values consistent with the existing backend rules. Do not introduce new business rules, discount percentages, availability calculations, or financial formulas based solely on a mockup.
- If a design element depends on data the application does not provide, omit it or flag the missing requirement rather than inventing data.
- Preserve the original empty-results behavior, including the required Ukrainian message and full-catalog fallback, if this is part of the current implementation/specification.
- Treat booking/request handling as backend functionality. Do not imply that a client-side-only form submits or reserves a tour unless a real existing handler supports that action.

## 6. Security and Access Control

- Preserve the existing server-side authentication, session, authorization, and role checks if they exist in the project.
- Financial reports and other administrator-only information must remain protected by the backend. Hiding a navigation link or section with CSS/JavaScript is not access control.
- Escape untrusted values before rendering them in HTML. In PHP templates, use the project's established escaping approach; use `htmlspecialchars` appropriately where compatible with the existing code and PHP version.
- Validate and handle request input using existing backend conventions. Do not trust client-side validation as a security boundary.
- Do not expose credentials, internal configuration, sensitive user data, or private financial data to public pages or client-side scripts.
- Avoid introducing unsafe HTML insertion or executing user-provided content as code.
- Do not weaken existing validation, authorization, or error handling to make a visual component easier to implement.

## 7. Dependencies and External Services

- Prefer the project's existing dependencies and native HTML, CSS, JavaScript, and PHP capabilities.
- Do not add frameworks, libraries, packages, build tools, external APIs, analytics, trackers, or third-party services unless the task requires them and the change is explicitly justified.
- Do not introduce a new package manager or modify dependency manifests without first confirming the repository's setup and need.
- Design references may use remote stock images, demo contacts, or sample data. Do not copy these into production data or present them as real agency information.
- External fonts may be used to match the approved design when consistent with the project setup and connectivity requirements. Prefer the fonts specified by the design reference, with sensible local fallbacks.
- Do not add remote image dependencies for tour cards/details when the application already provides images or image paths through its data. A decorative hero image may follow the reference if it is appropriate and available.
- Do not send project or user data to third-party services.

## 8. Design References

- Treat `references/design-reference.html` as the primary visual reference **if the file exists in the repository**.
- Read the accompanying `DESIGN-SPEC.md` or similarly named design specification if present, and read `TASK.md` for the current implementation scope.
- First inspect the actual repository and map reference sections to existing templates and components. Reference filenames and suggested mappings may differ from the real project.
- Match the approved reference’s layout, typography, colors, spacing, responsive behavior, component hierarchy, interaction states, and Ukrainian copy where applicable.
- Reuse documented design tokens and component styles rather than inventing an unrelated visual system.
- Treat the reference as a **visual guide, not a source of backend logic or production data**.
- Do not copy mock tour arrays, demo prices, sample hotel data, fake contact details, demo role switches, client-only booking handlers, or unsupported controls from the reference.
- Implement reference-only controls only when corresponding functionality already exists in the backend. Do not remove existing backend-supported controls merely because they are absent from the reference.
- Keep any marketing claims in the hero, steps section, or footer consistent with verified project information. Omit claims or contact details that cannot be confirmed.
- If the reference conflicts with existing functionality or the current task, preserve backend behavior and record the discrepancy rather than silently breaking functionality.

## 9. Responsive Design and Accessibility

- Follow the responsive breakpoints and behavior documented in the design specification when available.
- Test layouts at **1280 px, 900 px, and 375 px** wide.
- Avoid horizontal page overflow. Wide data tables may scroll within their own container.
- Use semantic HTML and maintain a logical heading hierarchy.
- Associate every form control with an accessible label. Preserve keyboard operation and visible focus indicators.
- Use appropriate accessible status announcements for changing result counts where compatible with the existing server-rendered flow.
- Respect `prefers-reduced-motion: reduce`; motion must not be required to reveal or access content.
- If JavaScript is unavailable, essential content must remain visible and core server-rendered functionality should remain usable.

## 10. Verification Workflow

For each task:

1. **Inspect:** Read the relevant templates, styles, scripts, data-access functions, and request handlers before changing them. Check repository instructions and available test/lint commands if present.
2. **Plan:** Identify the smallest set of files that can implement the requested change without altering backend behavior.
3. **Implement:** Make focused changes and preserve existing server-side behavior and project conventions.
4. **Review the diff:** Look for accidental changes to form names/actions/methods, URLs, request parameters, access checks, data sources, encoding, or unrelated files.
5. **Run available checks:** Use existing project tests, linters, or validation commands when configured. Do not claim a check passed unless it was actually run.
6. **Test behavior:** Where applicable, verify catalog rendering, search, filters, sorting, reset/clear behavior, empty results, detail links, and administrator-only report access.
7. **Test visuals:** Check the specified viewport widths and compare the result with the reference. Confirm responsive layout, visible focus, correct Ukrainian text, and reduced-motion behavior.
8. **Report:** Summarize changed files, checks actually performed, any unresolved limitations, and any requirement that would need backend changes.

If no automated test setup exists, perform the feasible manual checks and state that automated tests were unavailable. Never invent test results.

## 11. Scope Control

- `TASK.md` defines the current task and acceptance criteria; this file defines persistent working rules.
- Do not duplicate the full task specification here. Consult `TASK.md` for the requested work and its stage-by-stage plan.
- Distinguish required behavior from optional enhancements. Do not implement optional ideas without approval.
- If a requirement cannot be fulfilled without changing backend behavior, adding a dependency, inventing data, or weakening security, stop short of that change and report the constraint.
- Because this file is a draft, verify all instructions against the actual repository before relying on assumptions about the current implementation.
