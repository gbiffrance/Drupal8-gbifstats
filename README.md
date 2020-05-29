GBIF Stats
==========

Générateur de statistiques GBIF pour Drupal 8.

Instructions
------------

1. Dézipper l'archive dans le dossier *modules/custom* de votre installation Drupal. Activez-le ensuite dans l'interface graphique sur la page d'administration des modules (`[URL_de_votre_page_d_accueil]/admin/modules`).

2. Générer les fichiers de données en visitant la page suivante : `[URL_de_votre_page_d_accueil]/gbifstats/generate/{country}` ; `{country}` étant le code en 2 lettres du pays voulu.

3. Pour voir les données du pays, visitez la page `[URL_of_Drupal]/gbifstats/display/{country}`

---

Il existe 3 types de permissions dans le module GBIF Stats : 
    *install GBIF Stats* : pour installer le module, 
    *generate GBIF Stats* : pour la generation de données (l'accès est restreint de base) 
    *view GBIF Stats* : pour l'affichage des stats.

Important
---------
Vérifiez que Drupal puisse écrire dans le dossier `data` du module. Si ce n'est pas le cas, suivez les instructions du fichier READEME.md du dossier `data` 

Attention
---------

Ce module est en cours de travail. Reportez tout bugs et suggestions.

---
---

GBIF Stats
==========

GBIF Statistiques generator for Drupal 8.

Instructions
------------

1. Unpack the archive in the *modules/custom* folder (currently in the root of your Drupal 8 installation) and enable it in the administrative module page (`[URL_of_home_page]/admin/modules`).

2. Visit `[URL_of_home_page]/gbifstats/generate/{country}` to generate the files who containst information about the country;`{country}` is the two-letter country code.

3. Visit `[URL_of_Drupal]/gbifstats/display/{country}` to see your page displaying the information.

---

3 permissions are availables on the GBIF Stats module : 
    *install GBIF Stats* : to install the module, 
    *generate GBIF Stats* : to the data file generation (acces restricted by default), 
    *view GBIF Stats* : to watch the gbif stats

If you need the information for other modules, be advice than you will need *generate GBIF Stats* permission.

Important
---------
Drupal must have the right to write into the folder `data`. If that not the case, follow the instructions of the README.md of the `data` folder. 


Attention
---------

This module is a work in progress. Please report bugs and suggestions.