# AGENTS.md — Project Instructions for Codex

## 1. Project Context
This is SIMPEL, a web application built with Laravel and PHP.

Before implementing any feature, inspect the existing project structure and follow the conventions already used in the codebase.

## 2. Existing Technology
The project may use:
- Laravel and Blade templates
- PHP
- JavaScript and jQuery
- Axios
- Tailwind CSS
- Vite
- DataTables
- A relational database

Verify the actual versions and installed packages before using specific APIs or features.

## 3. Coding Rules
- Follow the existing MVC architecture and naming conventions.
- Reuse existing layouts, components, helpers, and JavaScript patterns where appropriate.
- Keep controllers, models, Blade views, JavaScript, and routes organized according to the existing project structure.
- Avoid unnecessary refactoring or unrelated changes.
- Do not invent database tables, columns, model names, route names, or relationships. Inspect the project first.
- Validate incoming data on the server side.
- Follow Laravel security practices, including authorization, CSRF protection, and safe handling of user input.
- Do not expose credentials, tokens, secrets, or `.env` contents.

## 4. Before Making Changes
- Read the relevant feature specification and inspect related existing files.
- Explain the implementation plan and identify missing requirements.
- Ask for clarification when an important design or database decision is uncertain.
- Keep changes limited to the requested feature.

## 5. Safety Rules
- Do not run database migrations.
- Do not modify or delete database data.
- Do not run destructive commands.
- Do not install, remove, or upgrade packages without explicit approval.
- Do not overwrite existing files without inspecting their contents first.
- Do not commit or push changes to Git without explicit approval.

## 6. Verification
After implementation, report:
- Files created or modified.
- Important implementation details.
- Checks or tests performed and their results.
- Any remaining issues or manual steps required.

## 7. File Safety and Deletion Policy

- NEVER delete any existing file or directory.
- NEVER move or rename existing files or directories without explicit approval.
- NEVER overwrite or replace an existing file without inspecting its contents first and explaining the intended changes.
- If a file appears unused, obsolete, duplicated, or unnecessary, DO NOT delete it. Instead, provide a recommendation with:
  1. The exact file path.
  2. The reason it may be unnecessary.
  3. The potential impact of removing it.
  4. Any dependencies or references that should be checked first.
- Leave all deletion decisions to the user. The user will delete files manually if appropriate.
- Prefer minimal, targeted changes to existing files.
- Do not remove existing functions, routes, validation rules, UI elements, or business logic unless explicitly requested and approved.
- Before making significant changes, explain which files will be created or modified.
- After implementation, report all created and modified files.
- If a requested change appears to require deleting or removing existing content, stop and ask the user for approval first.

Do not claim a test passed unless it was actually run and passed.