AGENTS.md — TourKit
Project
TourKit is a Ukrainian-language travel agency website built with PHP, HTML, CSS, and vanilla JavaScript.
Core rules
Preserve the existing PHP architecture and file structure.
Treat db.php as the source of truth for tour data. Never import fictional data from design references.
Preserve existing GET/POST parameter names and the search flow unless a task explicitly requires a bug fix.
Do not rewrite the project from scratch.
Do not add databases, APIs, frameworks, dependencies, or paid services unless explicitly requested.
Do not modify references/design-reference.html. It is a read-only visual reference.
Treat DESIGN-SPEC.md as the source of truth for visual requirements.
Keep all user-facing text in Ukrainian.
Escape dynamic output with htmlspecialchars() using appropriate encoding.
Validate and normalize external input before using it in filtering or output.
Workflow
Inspect the relevant existing files before making changes.
For multi-file tasks, create a concise implementation plan first.
Do not edit files until the user approves the plan.
Make only changes required by the current task.
Preserve existing working functionality.
Do not run terminal commands, install packages, or modify files outside the project without explicit permission.
After implementation, report changed files, explain the changes, and list checks performed and any remaining issues.
Design implementation
Match the original reference and DESIGN-SPEC.md, including section order, layout, spacing, typography, colors, and responsive behavior.
Do not omit visible sections, especially the Hero and footer.
Reuse existing design tokens and styles wherever possible.
Do not approximate design values when exact values are available in the reference.
Keep the reference file unchanged.
Validation
Check PHP syntax where PHP CLI is available.
Test form submission, query parameters, and all search filters.
Check empty-result states and invalid input.
Verify responsive layouts at the breakpoints defined in DESIGN-SPEC.md.
Never claim a test passed unless it was actually run.

