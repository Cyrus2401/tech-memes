# DESIGN.md - Contrat de Design du Projet

Ce document définit les règles strictes de design pour le projet Tech Memes. Toute implémentation doit respecter ces spécifications pour garantir une qualité professionnelle.

---

## 1. Thème Visuel & Concept

-   **Concept**: Clean Tech & Emerald Green (Light Mode)
-   **Description**: Un thème clair épuré haut de gamme dédié aux développeurs, mêlant des surfaces blanches épurées, des bordures fines et des touches de vert émeraude vif.
-   **Inspiration UI/UX Pro Max**: Style "Clean Tech" et "Minimalist"

## 2. Palette de Couleurs

| Rôle | Couleur | Utilisation |
| :--- | :--- | :--- |
| Background | `rgb(249, 250, 251)` | Arrière-plan global (Gris très clair) |
| Surface | `rgb(255, 255, 255)` | Panneaux, cartes, sections flottantes (Blanc pur) |
| Primary | `#10b981` | Boutons d'action importants, liens actifs |
| Primary Hover | `#059669` | État hover/actif des boutons principaux |
| Border | `rgb(229, 231, 235)` | Bordures fines et contours subtils |
| Border-Hover | `#10b981` | Bordures de cartes ou d'inputs survolés (Accent vert) |
| Text | `#111827` | Texte principal à fort contraste (Gris anthracite) |
| Text-Muted | `rgb(75, 85, 99)` | Texte secondaire (Gris neutre intermédiaire) |
| Danger | `#ef4444` | Actions destructrices (suppression, blocage) |
| Success | `#10b981` | Messages de succès et statuts activés |

## 3. Typographie

-   **Display (Titres)**: `Plus Jakarta Sans` (Source: Google Fonts)
-   **Body (Corps)**: `Plus Jakarta Sans` (Source: Google Fonts)
-   **Monospace**: `JetBrains Mono` / `SFMono-Regular` (Pour les éléments de style code ou timestamps)

## 4. Hiérarchie Typographique

-   **H1**: `32px` / `Font-Weight: 800` / `Line-Height: 1.2` / `Tracking: -0.025em`
-   **H2**: `24px` / `Font-Weight: 700` / `Line-Height: 1.3`
-   **H3**: `20px` / `Font-Weight: 700` / `Line-Height: 1.4`
-   **P (Paragraphe)**: `15px` / `Font-Weight: 400` / `Line-Height: 1.6`
-   **Small (Méta/Légendes)**: `12px` / `Font-Weight: 500` / `Line-Height: 1.5`

## 5. Espacement et Grille

-   **Base de la grille**: 8px (Tout doit être multiple de 8px : 8, 16, 24, 32, 48, 64, 96)
-   **Gouttière**: 24px
-   **Padding Section Vertical**: 96px
-   **Padding Section Horizontal**: 24px
-   **Radius (Arrondis)**: `16px` pour les cartes, `8px` pour les boutons/inputs (Multiples de 4px)

## 6. Composants et États

### Boutons
-   **Primaire**: Fond `--primary`, texte blanc, arrondis `8px`.
-   **Primaire Hover**: Fond `--primary-hover`, translation vertical légère (`-1px`), ombre portée orange subtile.
-   **Secondaire**: Fond transparent, bordure `--border`, texte `--text`.
-   **Secondaire Hover**: Fond `rgba(249, 115, 22, 0.1)`, bordure `--primary`, texte `--text`.
-   **Ghost**: Fond transparent, texte `--text-muted`.
-   **Ghost Hover**: Fond `rgba(0, 0, 0, 0.05)`, texte `--text`.

### Cartes (Meme Cards)
-   **Structure**: Fond `--surface`, bordure fine `1px` avec `--border`, arrondis `16px`.
-   **Interaction**: Transition 300ms sur hover (translation de `-4px`, lueur orange fine sur la bordure, ombre portée soft).

### Formulaires
-   **Inputs**: Fond `#ffffff`, bordure `--border`, texte `--text`, arrondis `8px`.
-   **Focus**: Bordure `--primary`, lueur subtile.

## 7. Motion et Animations

-   **Transitions**: 200ms ease-out pour le hover des boutons.
-   **Cartes (GSAP)**: Stagger de 100ms par carte, animation d'entrée (`opacity: 0, y: 30`, durée: 0.4s).
-   **Accessibilité**: Respect de la règle `prefers-reduced-motion`.
