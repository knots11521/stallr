# Main UI Spacing

Shared convention for vertical rhythm and page gutters across Livewire views and the auth
layout stack. The auth views are the authoritative reference for "actual utility use";
everything else derives from the same `gap-6` vertical rhythm.

## Auth vs App — Layout Architecture

Auth pages and app pages use **different layout architectures**:

- **Auth** (`layouts/auth/simple.blade.php`): The `<div>` wrapper owns `p-6 md:p-10` (symmetric
  24px→40px). Auth page content adds **no** extra padding — only `flex flex-col gap-6`.
- **App** (`layouts/app.blade.php`): `<flux:main>` provides the page padding via
  `class="md:!p-10 lg:!p-10"` (overriding the component's default `p-6 lg:p-8`). Page content
  is wrapped in `<x-page-section>` which provides **only** max-width, flex layout, and gap —
  **no padding of its own**. This ensures single-source-of-truth padding matching auth.

## Canonical tiers

| Tier | Scope | Implementation | Source |
|---|---|---|---|
| Page padding | App layout (all non-auth pages) | `<flux:main class="md:!p-10 lg:!p-10">` on `p-6` | `layouts/app.blade.php:2` |
| Page section | Standard Livewire page views | `<x-page-section>` (provides `mx-auto flex w-full max-w-* flex-col gap-6`, no padding) | `resources/views/components/page-section.blade.php` |
| Auth layout outer pad | Auth layout outer div | `flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10` | `layouts/auth/simple.blade.php:7` |
| Auth layout inner wrap | Auth layout inner div | `flex w-full max-w-sm flex-col gap-2` | `layouts/auth/simple.blade.php:8` |
| Auth page content | Auth views (inside layout) | `flex flex-col gap-6` | `livewire/auth/login.blade.php:8` (wraps the slot) |
| Auth form | Auth forms | `flex flex-col gap-6` | `livewire/auth/login.blade.php:10`, `register.blade.php:14` |
| Button action row | Submit button wrapper | `flex items-center justify-end` | `livewire/auth/login.blade.php:47` |
| Page footer links | Auth page footers | `space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400` | `livewire/auth/login.blade.php:54` |

### Spacing parity

| Breakpoint | Auth layout | App layout | Match |
|---|---|---|---|
| Mobile (< 768px) | `p-6` = 24px | `p-6` = 24px (flux:main default) | ✓ |
| md (≥ 768px) | `md:p-10` = 40px | `md:!p-10` = 40px (override) | ✓ |
| lg (≥ 1024px) | `md:p-10` = 40px | `lg:!p-10` = 40px (override flux main's `lg:p-8`) | ✓ |

The `!p-10` / `lg:!p-10` uses Tailwind's important prefix (`!`) to reliably override
`flux:main`'s built-in `p-6 lg:p-8` classes, which are concatenated by Flux's class builder
and cannot be overridden by source order alone.

## The `x-page-section` component

All standard Livewire page views wrap their content in `<x-page-section>` instead of
manually writing `<section class="mx-auto flex w-full max-w-* ...">`.

### Props

| Prop | Default | Purpose |
|---|---|---|
| `maxWidth` | `5xl` | Content width: `sm`, `md`, `lg`, `xl`, `2xl`, `3xl`, `4xl`, `5xl`, `6xl`, `7xl` |
| `gap` | `6` | Vertical rhythm between top-level children (Tailwind `gap-{n}` scale) |

### The one variable per page

Every standard page uses `<x-page-section>`. The only values that vary per page are the
`maxWidth` and `gap` props:

| `maxWidth` value | Pages |
|---|---|
| `7xl` | dashboard |
| `6xl` | schools/index, schools/members, academic/manage, performance/index |
| `5xl` | assessments index/edit/take/results/global-index/student-result/student-empty, assignments index/global-index/submissions, learning-environments/index, learning-materials/global-index, ai/assistant |
| `4xl` | learning-environments/manage-members, learning-materials/index |
| `md` | join-school |

| `gap` value | Pages |
|---|---|
| `10` | dashboard (hero needs extra section breathing room) |
| `8` | performance/index (dashboard-style) |
| `6` | all other pages (default) |

## Compliant example

```blade
<x-page-section max-width="5xl">
    <div>
        <flux:heading size="xl">{{ $model->name }}</flux:heading>
        <flux:text>{{ __('Listing') }}</flux:text>
    </div>
</x-page-section>
```

With custom gap:

```blade
<x-page-section max-width="7xl" gap="10">
    {{-- content --}}
</x-page-section>
```

Auth page content (inside the layout, no extra padding):

```blade
<div class="flex flex-col gap-6">
    {{-- Auth header + form --}}
</div>

<form class="flex flex-col gap-6">
    {{-- form fields --}}
</form>
```

## Deviation checklist (intentional — DO NOT change)

- `livewire/settings/{profile,appearance,security}.blade.php:1` — `<section class="w-full">`
  (uses `x-settings.layout` which supplies its own sidebar + content spacing; the outer
  `<section>` has no padding — page padding comes from `flux:main` in the app layout)
- `livewire/auth/verify-email.blade.php:4` — `mt-4 flex flex-col gap-6` (intentional top offset)
- `livewire/auth/two-factor-challenge.blade.php` — complex Alpine.js layout, `space-y-5`, `my-5`
- `livewire/assessments/student-empty.blade.php:13` — `py-10` on an inner `flux:card` (intentional
  centered empty state)

## Enforcement

When adding or editing a standard Livewire page view, use `<x-page-section>` instead of
manually writing `<section class="mx-auto flex w-full max-w-* ...">`. Only set `max-width`
or `gap` props if the page differs from the defaults (`max-width="5xl"`, `gap="6"`).

Page padding is managed centrally by `<flux:main class="md:!p-10 lg:!p-10">` in
`layouts/app.blade.php`. Do **not** add `p-*` classes to `<x-page-section>` or to page
`<section>` wrappers — this would create double-padding.

Re-run Pint after edits. Note: Pint is PHP-only and does not reformat Blade; use `npx prettier`
or manual review for `.blade.php` changes.
