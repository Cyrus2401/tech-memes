# 🚀 Tech Memes - Product Roadmap & Functional Backlog

Ce rapport détaille l'ensemble des fonctionnalités manquantes, des améliorations d'expérience utilisateur (UX) et des optimisations techniques recommandées pour transformer le projet **Tech Memes** actuel (simple galerie multi-auteurs) en une plateforme communautaire interactive et dynamique pour développeurs.

Vous pouvez copier-coller ces sections directement dans les **Issues GitHub** de votre projet.

---

## 🟢 Étape 1 : Engagement & Interactivité (Social & Community)
*Ces fonctionnalités visent à faire passer l'application d'une lecture passive à un espace d'échange active pour les développeurs.*

### 1. Système de Votes / Appréciations (Style Reddit/StackOverflow)
- [ ] **Description** : Permettre aux visiteurs de voter pour les mèmes afin de faire remonter les plus drôles.
- [ ] **Sous-tâches** :
  - Ajouter un bouton "Upvote" et "Downvote" (ou système de "Like" simple) sur chaque carte de mème.
  - Sauvegarder les votes en base de données par adresse IP (pour les anonymes) et par ID utilisateur (pour les connectés).
  - Ajouter des filtres de tri sur la page d'accueil : **Nouveautés** (tri chronologique), **Top** (tri par nombre de votes cumulés) et **Hot** (algorithme combinant la nouveauté et les votes récents).

### 2. Espace Commentaires & Débats de Devs
- [ ] **Description** : Ouvrir un espace de discussion sous chaque mème pour permettre aux développeurs de débattre (ex: guerres d'éditeurs, langages, etc.).
- [ ] **Sous-tâches** :
  - Créer une table `comments` liée aux mèmes et aux utilisateurs.
  - Implémenter une vue détaillée pour chaque mème (`/meme/{slug}`) affichant le mème en grand et sa section de commentaires.
  - Permettre les réponses imbriquées (commentaires de niveau 2) pour structurer les conversations.
  - Ajouter des réactions émojis rapides sur les commentaires (😂, 👍, 🚀, ☕).

### 3. Favoris & Collection Personnelle
- [ ] **Description** : Permettre aux contributeurs connectés de sauvegarder leurs mèmes préférés pour les retrouver facilement.
- [ ] **Sous-tâches** :
  - Ajouter un bouton "Signet / Sauvegarder" sur les mèmes.
  - Créer un onglet "Mes Favoris" dans l'espace membre.

---

## 🟡 Étape 2 : Navigation, Recherche & Découverte (Content Discovery)
*Permettre aux utilisateurs de trouver rapidement du contenu ciblé sur leurs technologies favorites.*

### 4. Système de Catégories et Tags Technologiques
- [ ] **Description** : Associer des tags aux mèmes pour filtrer le contenu par langage ou domaine.
- [ ] **Sous-tâches** :
  - Créer une table `tags` (ex: `#php`, `#javascript`, `#sysadmin`, `#git`, `#docker`).
  - Permettre aux contributeurs de sélectionner jusqu'à 3 tags lors de la publication d'un mème.
  - Afficher les tags sous chaque mème et les rendre cliquables pour filtrer instantanément le flux de la page d'accueil.

### 5. Barre de Recherche Textuelle (Fuzzy Search)
- [ ] **Description** : Permettre aux utilisateurs de chercher des mèmes par titre ou par tag.
- [ ] **Sous-tâches** :
  - Ajouter un champ de recherche dans le header ou en haut de la liste de mèmes.
  - Implémenter une recherche textuelle en SQL (ou via Laravel Scout / Algolia si le volume grandit).

### 6. Bouton "Mème Aléatoire"
- [ ] **Description** : Un classique des plateformes de divertissement pour découvrir du contenu au hasard.
- [ ] **Sous-tâches** :
  - Ajouter un bouton "Mème Aléatoire" dans la barre de navigation.
  - Rediriger vers `/meme/random` qui sélectionne un ID aléatoire en base et affiche sa page détaillée.

---

## 🔵 Étape 3 : Expérience Contributeur & Création (Creator Experience)
*Faciliter et enrichir la création de contenu pour attirer plus de contributeurs.*

### 7. Générateur de Mèmes en Ligne (Meme Generator)
- [ ] **Description** : Intégrer un outil simple pour créer des mèmes directement depuis le site sans logiciel externe.
- [ ] **Sous-tâches** :
  - Proposer des templates populaires d'images de mèmes vierges (ex: "Drake Hotline", "Distracted Boyfriend").
  - Ajouter des champs texte pour le haut et le bas de l'image.
  - Utiliser l'API Canvas HTML5 pour générer l'image finale en JavaScript avant l'upload.

### 8. Amélioration de l'Upload (Drag & Drop & Crop)
- [ ] **Description** : Moderniser le formulaire de dépôt de mème.
- [ ] **Sous-tâches** :
  - Rendre la zone d'upload réceptive au glisser-déposer de fichiers.
  - Permettre de coller directement une image depuis le presse-papier (`Ctrl+V` / `Cmd+V`).
  - Intégrer une option d'importation via URL d'image externe.
  - Ajouter un outil de recadrage/rognage (crop) avant validation.

---

## 🔴 Étape 4 : Modération & Administration (Governance)
*Donner aux administrateurs les outils pour maintenir la qualité et la sécurité du site.*

### 9. File d'Attente de Validation (Approval Queue)
- [ ] **Description** : Remplacer la publication directe par un système de soumission soumise à validation pour éviter le spam.
- [ ] **Sous-tâches** :
  - Ajouter un champ `status` (`pending`, `approved`, `rejected`) dans la table `memes`.
  - Quand un contributeur publie, le mème passe en `pending`.
  - Créer un espace "Modération" pour le Super Admin pour approuver ou rejeter les mèmes en attente.

### 10. Signalement de Contenu (Reporting System)
- [ ] **Description** : Permettre aux utilisateurs de signaler les doublons, le contenu hors-sujet ou inapproprié.
- [ ] **Sous-tâches** :
  - Ajouter un bouton "Signaler" sur chaque mème.
  - Demander le motif du signalement (Doublon, Hors-sujet, Spam, etc.).
  - Afficher les mèmes les plus signalés dans le tableau de bord du Super Admin pour action rapide (suppression ou archivage).

---

## 🟣 Étape 5 : Améliorations Techniques & SEO (Performance & Sharing)
*Optimiser le site pour le référencement et la performance.*

### 11. Cartes d'Aperçu pour les Réseaux Sociaux (Open Graph)
- [ ] **Description** : Permettre à un mème partagé sur Slack, Discord, Twitter/X ou LinkedIn de s'afficher sous forme de carte visuelle riche.
- [ ] **Sous-tâches** :
  - Injecter dynamiquement des balises `<meta property="og:image">` et `<meta property="og:title">` dans le `<head>` de la page de détail du mème.

### 12. Compression Automatique des Images (WebP)
- [ ] **Description** : Réduire le poids des fichiers hébergés pour économiser de la bande passante et accélérer le chargement des pages.
- [ ] **Sous-tâches** :
  - Installer `intervention/image` (package Laravel).
  - Convertir automatiquement toutes les images téléversées au format `.webp` avec une qualité de 80% lors de l'enregistrement en base.

---

## 🟤 Étape 6 : Spécificités "Les Joies du Code" (Geek-Oriented features)
*Améliorations calquées sur le comportement des plateformes humoristiques de dev.*

### 13. Support Optimisé des GIFs Animés (Play/Pause)
- [ ] **Description** : Les mèmes de dev utilisent massivement des GIFs. Pour éviter de surcharger le navigateur et améliorer l'accessibilité, les GIFs doivent pouvoir être figés.
- [ ] **Sous-tâches** :
  - Intégrer une librairie JS (ex: `gifffer` ou via canvas) pour afficher une image statique du premier frame avec un badge "GIF".
  - Jouer le GIF uniquement au survol ou au clic de l'utilisateur.

### 14. Mode "Focus / Slide Show" au Clavier
- [ ] **Description** : Permettre de naviguer d'un mème à l'autre en plein écran avec les flèches directionnelles du clavier pour une expérience de procrastination optimale.
- [ ] **Sous-tâches** :
  - Créer un mode "Plein Écran / Focus" accessible depuis chaque mème.
  - Écouter les événements clavier `ArrowRight` (mème suivant) et `ArrowLeft` (mème précédent).

### 15. Flux RSS pour les Devs & Newsletter Hebdomadaire
- [ ] **Description** : Offrir aux développeurs les canaux classiques pour suivre l'actualité des mèmes (Lecteur RSS, Email).
- [ ] **Sous-tâches** :
  - Créer une route `/feed` générant un fichier XML au format RSS.
  - Mettre en place une newsletter hebdomadaire automatique reprenant les 5 mèmes les plus upvotés de la semaine (intégration Mailchimp, Brevo ou Laravel Mail).

### 16. Mode Sombre (Dark Mode) Natif
- [ ] **Description** : Vital pour le confort visuel des développeurs naviguant sur le site tard dans la nuit.
- [ ] **Sous-tâches** :
  - Ajouter un bouton toggle "Clair / Sombre" dans la barre de navigation.
  - Configurer des classes CSS spécifiques (ou variables CSS de thème) et persister le choix de l'utilisateur en `localStorage`.
