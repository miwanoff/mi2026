# AGENTS.md

## Project Information

Project name: countries-2026-API

Project type: PHP web application

Environment:

- PHP
- XAMPP / Apache
- MySQL (if applicable)
- Visual Studio Code
- Kilo Code

## Project Paths

Project root is the folder containing this AGENTS.md file.

The project is accessible in the browser at:

`http://localhost/Web3-2026/mi/countries-2026-API/`

Important:

- The localhost URL is a browser address, NOT a filesystem path.
- Never construct filesystem paths from the localhost URL.
- Always use the actual VS Code workspace root.
- Use relative paths from the project root whenever possible.
- Use `__DIR__` in PHP to build paths relative to the current PHP file.

## Working Rules

1. Before working, verify that the current workspace contains this AGENTS.md file.
2. Check the actual workspace root and project files.
3. Do not assume or invent absolute Windows paths.
4. If a required file cannot be found, report the actual directory being searched.
5. Do not search unrelated folders outside the project.
6. Do not modify files unless explicitly requested.
7. Preserve the existing project structure and functionality.
8. Do not expose API keys or other secrets.
9. Never read or output `.env` contents.
10. Use `.env.example` only to understand the required environment variables.

## Main Project Files

- `index.php` — main page
- `functions.php` — project functions
- `db.php` — country data
- `config.php` — configuration and environment variables

Before making changes, inspect the relevant files and explain which files need modification.
