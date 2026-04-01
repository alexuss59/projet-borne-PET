# projet-borne-PET
### créez votre branche avec votre prénom pour développer
### la branche main ne doit contenir que du code fonctionnel 
**git clone [URL_DU_DEPOT]** : Télécharge le projet GitHub sur ton ordinateur pour la toute première fois. (L'URL se trouve sur la page d'accueil de votre dépôt, bouton vert "Code")

**git pull** : À faire avant de commencer à coder. Ça télécharge les modifications que tes camarades ont envoyées pendant que tu ne travaillais pas. Ça évite les conflits.

**git add .** : Ajoute tous les fichiers que tu viens de modifier ou de créer dans la "salle d'attente" (l'index), pour les préparer à la sauvegarde. (Le point à la fin est important, il veut dire "tout prendre").
**git commit -m "Ton message"** : Valide la sauvegarde de ton travail sur ton PC. Le message doit être clair pour l'équipe.
- **Mauvais** exemple : git commit -m "truc"
- **Bon exemple** : git commit -m "Ajout de la fonction de test de la borne"
**git push** : Envoie définitivement tes commits validés vers le dépôt GitHub partagé. C'est à ce moment-là que les autres peuvent voir ton travail.
  
## Pour éviter de casser la branche principale (main) qui doit toujours fonctionner, on crée des branches parallèles pour chaque nouvelle fonctionnalité.
**git branch [nom_de_la_branche]** : Crée une nouvelle branche (ex: git branch interface-graphique).

**git switch [nom_de_la_branche]** : Te déplace sur cette branche pour commencer à y coder. (Anciennement git checkout, qui fonctionne toujours).

**git switch main** : Pour revenir sur la branche principale quand tu as fini.

**git merge [nom_de_la_branche]** : Fusionne le travail de ta branche terminée dans la branche principale. (À faire de préférence directement sur le site GitHub via une "Pull Request" pour que tes camarades valident ton code avant de fusionner).

## **git status** : C'est ta boussole. Tape ça si tu es perdu. Ça t'indique exactement où tu en es : quels fichiers sont modifiés, si tu as oublié de faire un add ou un commit, et sur quelle branche tu te trouves.
