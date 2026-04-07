# Design System Specification: The Kinetic Luminary

## 1. Overview & Creative North Star: "The Digital Kineticist"
The "Digital Kineticist" is our Creative North Star. We are moving away from the static, boxy layouts of traditional corporate software. Instead, this design system treats the interface as a living, breathing ecosystem of momentum. 

To achieve a "High-End Editorial" feel for a gamification platform, we bypass the "standard" dashboard look. We use **intentional asymmetry**, **overlapping glass layers**, and **extreme typographic contrast** to create an experience that feels like a premium sports brand crossed with a high-end fintech app. We don't just "show" progress; we celebrate it through visual depth and vibrant, kinetic energy.

---

## 2. Colors: Vibrancy & The "No-Line" Rule
Our palette balances a professional, clinical base with "Electric" accents to drive motivation.

### The Palette
- **Primary (`#0846ed`):** Electric Blue. Used for core action and progress.
- **Secondary (`#751fe7`):** Royal Violet. Used for prestige elements (Leaderboards, Milestones).
- **Tertiary (`#006a28`):** Emerald Green. Reserved for "Success" and quest completion.
- **Neutral Base (`#f4f7f9`):** A sophisticated, cool gray that prevents eye strain.

### The "No-Line" Rule
**Explicit Instruction:** Designers are prohibited from using 1px solid borders for sectioning. 
Structure must be defined through:
1.  **Tonal Shifts:** Place a `surface-container-lowest` card on a `surface-container-low` background.
2.  **Negative Space:** Use the spacing scale to create clear mental boundaries.
3.  **Shadow Depth:** Use ambient, tinted shadows to lift elements rather than boxing them in.

### The "Glass & Gradient" Rule
Standard flat colors lack "soul." Main CTAs and quest nodes should utilize a subtle linear gradient from `primary` to `primary_container`. For floating UI elements (like reward notifications), apply **Glassmorphism**: use `surface_container_lowest` at 80% opacity with a `24px` backdrop blur.

---

## 3. Typography: Editorial Authority
We use a triple-font approach to create a "techy" yet sophisticated hierarchy.

*   **Display & Headlines (Space Grotesk):** This is our "Editorial Voice." It’s wide, geometric, and aggressive. Use `display-lg` for big achievement numbers and `headline-md` for quest titles.
*   **Titles & Body (Inter):** The "Workhorse." Inter provides a neutral, high-readability counterweight to the expressive headlines. 
*   **Labels (Plus Jakarta Sans):** Used for micro-copy and metadata. It adds a "premium tech" finish to smaller details.

**Hierarchy Tip:** Pair a `display-lg` achievement number with a `label-md` uppercase caption to create a "High-End Magazine" layout style within cards.

---

## 4. Elevation & Depth: Tonal Layering
We reject the flat grid. Depth is achieved through a "Stacking Principle."

*   **The Layering Principle:** 
    *   **Level 0 (Background):** `surface` (`#f4f7f9`).
    *   **Level 1 (Sections):** `surface-container-low` (`#edf1f3`).
    *   **Level 2 (Cards):** `surface-container-lowest` (`#ffffff`).
    *   **Level 3 (Interactive/Floating):** Glassmorphic overlays.
*   **Ambient Shadows:** For floating badges or reward tiles, use a shadow with a blur of `32px` at `6%` opacity. The color should be tinted with `primary` (Electric Blue) to make the shadow feel like a glow rather than dirt.
*   **The "Ghost Border" Fallback:** If a divider is mandatory (e.g., in a complex list), use `outline_variant` at **15% opacity**. It should be felt, not seen.

---

## 5. Components: The Kinetic Toolkit

### Progress Bars (The "Pulse" Variant)
Forget flat bars. Use `primary` for the fill, but add a `primary_container` inner glow. The track should be `surface_container_high`. Use `roundedness-full` for a modern, pill-shaped aesthetic.

### Interactive Quest Nodes
Nodes should not be simple circles. Use `secondary_container` with a `secondary` 2px "Ghost Border." When active, the node should "glow" using a `primary` ambient shadow and an icon in `on_primary_container`.

### Leaderboard Cards
Forbid divider lines. Use a `surface-container-low` background for the even-numbered rows and `surface-container-lowest` for odd. The #1 rank should be 10% larger, overlapping the card below it to break the rigid vertical grid.

### Buttons
*   **Primary:** Gradient from `primary` to `primary_dim`. `roundedness-md`. No border.
*   **Secondary:** `surface_container_highest` background with `primary` text.
*   **Tertiary:** Transparent background, `label-md` typography, with a `primary` underline that only appears on hover.

### Reward Tiles
Use `secondary_fixed` for the background. Incorporate a subtle "Starfield" pattern or noise texture to give the reward a physical, collectible feel.

---

## 6. Do’s and Don’ts

### Do
*   **Do** use asymmetrical margins (e.g., 24px left, 40px right) in desktop headers to create an editorial feel.
*   **Do** overlap elements. Let a badge half-sit outside the top edge of a card to create depth.
*   **Do** use `primary` for data visualization but `tertiary` for "Completed" states.

### Don’t
*   **Don't** use pure black (`#000000`) for text. Use `on_surface` (`#2b2f31`) to maintain a premium, soft-touch feel.
*   **Don't** use 1px solid borders. If the design feels "loose," increase the contrast between your `surface-container` tiers instead.
*   **Don't** use standard "drop shadows." Use large, diffused ambient blurs that match the brand's energetic tone.
*   **Don't** center-align everything. Use left-aligned "Editorial" blocks to guide the eye through the "Quest" journey.