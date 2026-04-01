# 🚀 Projet Borne PET

> **⚠️ Règles d'or de l'équipe**
> * **Créez votre propre branche** avec votre prénom (ou le nom de la fonctionnalité) pour développer.
> * La branche `main` est sacrée : elle ne doit contenir **que du code fonctionnel et testé**.

---

## 📥 1. Premier démarrage (À faire une seule fois)

* **`git clone [URL_DU_DEPOT]`** : Télécharge le projet GitHub sur ton ordinateur pour la toute première fois. *(L'URL se trouve sur la page d'accueil de notre dépôt, via le bouton vert "Code").*

---

## 🔄 2. La routine quotidienne (Dans cet ordre précis)

* **`git pull`** : **À faire avant de commencer à coder.** Ça télécharge les modifications que les autres ont envoyées pendant que tu ne travaillais pas. C'est indispensable pour éviter les conflits de code.
* **`git add .`** : Ajoute tous les fichiers que tu viens de modifier ou de créer dans la "salle d'attente" (l'index), pour les préparer à la sauvegarde. *(Le point `.` à la fin est important, il veut dire "tout prendre").*
* **`git commit -m "Ton message"`** : Valide la sauvegarde de ton travail sur ton PC. Le message doit être clair pour le reste de l'équipe.
  * ❌ **Mauvais exemple :** `git commit -m "truc"`
  * ✅ **Bon exemple :** `git commit -m "Ajout de la fonction de test de la borne"`
* **`git push`** : Envoie définitivement tes commits validés vers le dépôt GitHub partagé. C'est à ce moment-là que les autres peuvent voir ton travail.

---

## 🌿 3. Gestion des branches (Protéger le main)

Pour éviter de casser la branche principale (`main`) qui doit toujours fonctionner, on crée des branches parallèles pour chaque nouvelle fonctionnalité.

* **`git branch [nom_de_la_branche]`** : Crée une nouvelle branche *(ex: `git branch interface-graphique`)*.
* **`git switch [nom_de_la_branche]`** : Te déplace sur cette branche pour commencer à y coder. *(Anciennement `git checkout`, qui fonctionne toujours).*
* **`git switch main`** : Pour revenir sur la branche principale quand tu as fini.
* **`git merge [nom_de_la_branche]`** : Fusionne le travail de ta branche terminée dans la branche principale. *(À faire de préférence directement sur le site GitHub via une "Pull Request" pour que l'équipe valide le code avant de l'intégrer).*

---

## 🆘 4. En cas de panique

* **`git status`** : C'est ta boussole. Tape ça si tu es perdu(e). Ça t'indique exactement où tu en es : quels fichiers sont modifiés, si tu as oublié de faire un `add` ou un `commit`, et sur quelle branche tu te trouves actuellement.
