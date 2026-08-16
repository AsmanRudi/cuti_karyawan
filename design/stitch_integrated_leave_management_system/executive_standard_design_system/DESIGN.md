---
name: Executive Standard Design System
colors:
  surface: '#fcf8ff'
  surface-dim: '#dcd9df'
  surface-bright: '#fcf8ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f6f2f9'
  surface-container: '#f0ecf3'
  surface-container-high: '#eae7ed'
  surface-container-highest: '#e4e1e8'
  on-surface: '#1b1b20'
  on-surface-variant: '#464650'
  inverse-surface: '#303035'
  inverse-on-surface: '#f3eff6'
  outline: '#777681'
  outline-variant: '#c7c5d2'
  surface-tint: '#55589c'
  primary: '#010025'
  on-primary: '#ffffff'
  primary-container: '#121358'
  on-primary-container: '#7d7fc7'
  inverse-primary: '#c0c1ff'
  secondary: '#4e599e'
  on-secondary: '#ffffff'
  secondary-container: '#a6b1fd'
  on-secondary-container: '#364285'
  tertiary: '#0e0100'
  on-tertiary: '#ffffff'
  tertiary-container: '#3d0d00'
  on-tertiary-container: '#bf7158'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#e1e0ff'
  primary-fixed-dim: '#c0c1ff'
  on-primary-fixed: '#0f1056'
  on-primary-fixed-variant: '#3d4083'
  secondary-fixed: '#dee0ff'
  secondary-fixed-dim: '#bbc3ff'
  on-secondary-fixed: '#031158'
  on-secondary-fixed-variant: '#354185'
  tertiary-fixed: '#ffdbd0'
  tertiary-fixed-dim: '#ffb59d'
  on-tertiary-fixed: '#390c00'
  on-tertiary-fixed-variant: '#72351f'
  background: '#fcf8ff'
  on-background: '#1b1b20'
  surface-variant: '#e4e1e8'
typography:
  h1:
    fontFamily: Inter
    fontSize: 36px
    fontWeight: '700'
    lineHeight: 44px
    letterSpacing: -0.02em
  h1-mobile:
    fontFamily: Inter
    fontSize: 28px
    fontWeight: '700'
    lineHeight: 34px
    letterSpacing: -0.01em
  h2:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
    letterSpacing: -0.01em
  h3:
    fontFamily: Inter
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-sm:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
    letterSpacing: 0.05em
  label-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  unit: 4px
  container-max-width: 1440px
  gutter: 24px
  margin-desktop: 40px
  margin-mobile: 16px
  stack-sm: 8px
  stack-md: 16px
  stack-lg: 32px
---

## Brand & Style
The design system focuses on the dual needs of HR administrators and employees: professional rigor and personal accessibility. The aesthetic is **Corporate Modern**, prioritizing high clarity, functional whitespace, and a systematic approach to complex information.

The visual language evokes reliability and precision through a structured layout, while the use of teal accents provides a sense of calm and progress. It avoids unnecessary decoration, opting for a clean, utilitarian interface that minimizes cognitive load during administrative tasks and self-service requests.

## Colors
This design system utilizes a tiered blue palette to establish authority and trust. The **Primary Deep Navy** is reserved for high-level navigation and primary actions. The **Secondary Royal Blue** and **Steel Blue** are used for interactive elements and categorization. 

The **Teal/Aqua Accent** is the "success" and "action" driver, used for positive data visualizations (like accrued leave) and final submission buttons. 

**Status Indicators:**
- **Pending:** Amber/Gold to indicate caution and waiting.
- **Approved:** Emerald/Teal to indicate completion and success.
- **Rejected:** Soft Red to indicate an error or denial.

## Typography
Inter is used across all levels to ensure maximum legibility and a neutral, professional tone. 

- **Hierarchy:** Use H1 and H2 sparingly for page titles and major dashboard sections. 
- **Data Display:** Use `body-sm` for table data and `label-md` for table headers.
- **Micro-copy:** `label-sm` should be used for captions, helper text under inputs, and small metadata in employee cards.

## Layout & Spacing
The layout follows a **Fixed-Fluid hybrid grid**. Sidebars and navigation panels are fixed width (280px), while content areas expand up to a 1440px container.

- **Grid:** A 12-column grid is used for dashboards.
- **Rhythm:** All spacing must be multiples of 4px. Use `stack-md` (16px) for the standard gap between form fields and `stack-lg` (32px) for spacing between major sections or card groups.
- **Mobile:** Transition to a single-column layout with 16px horizontal margins. Navigation should collapse into a bottom bar or a "hamburger" drawer.

## Elevation & Depth
Depth is used to distinguish the workspace from the background. 

- **Surface Levels:** The background uses a very light grey (#F9FAFB). Content "cards" use a pure white background with a 1px border (#E5E7EB).
- **Shadows:** Use a "Soft Professional" shadow style: `0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)`. This provides just enough lift to signify interactivity without appearing heavy.
- **Z-Index:** Modals and slide-overs for "Apply Leave" should have a higher elevation with a 20% opacity black backdrop blur to keep focus on the task.

## Shapes
The design system adopts a **Rounded** corner strategy to soften the corporate atmosphere and make the ESS platform feel approachable.

- **Standard Components:** Buttons, Input Fields, and Chips use a 0.5rem (8px) radius.
- **Large Components:** Dashboard cards and modals use a 1rem (16px) radius for a more contemporary, "app-like" feel.
- **Status Indicators:** Use fully pill-shaped (rounded-full) corners for status badges (Pending, Approved) to distinguish them from actionable buttons.

## Components
Consistent implementation of these components ensures a unified user experience across HR and ESS modules.

- **Buttons:** Primary buttons use Deep Navy (#121358) with white text. Secondary buttons use a Steel Blue outline. "Apply" or "Submit" actions can use the Teal Accent (#36ADA3) to stand out.
- **Data Visualization:** Leave quotas should be represented by "Ring" or "Donut" charts using the Teal Accent for used leave and a light grey for remaining.
- **Status Chips:** 
  - *Pending:* Amber background (10% opacity) with dark amber text.
  - *Approved:* Teal background (10% opacity) with dark teal text.
  - *Rejected:* Red background (10% opacity) with dark red text.
- **Input Fields:** 1px solid border (#E5E7EB). On focus, use a 2px Royal Blue (#232F72) border. 
- **Employee Cards:** White surface, 8px radius, subtle shadow. Include a small circular avatar (40x40px), name in `body-md` bold, and role in `body-sm`.
- **List Items:** Use for payroll history or document lists. 16px padding, hover state with a subtle #F3F4F6 background change.