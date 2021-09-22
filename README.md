# Site studio Ghibli


## Membres du groupe

* Bauchez Marguerite
* Cocquerez Olivier
* Lebranchu Paul
* Lemaire Raphaelle

## Source des images

* Image de fond : https://animesher.com/entry/my-neighbour-totoro-princess-mononoke-spirited-away-443835/
* Image de fond (page d'erreur) : https://dribbble.com/search/mononke
* Image des puces de liste : adaptation de la créature calcifère par Lemaire Raphaelle
## Intsallation du site

* étape 1: modifier le fichier mysql_config.php pour pouvoir vous connecté à une base de données

* étape 2: si votre base de données ne contient pas les tables du sites, nous vous avons fourni un fichier BDD.sql(fichier 
qui a servi à la création des tables initiale) mais vous pouvez également importer le fichier dump.sql se trouvant dans le 
repertoire dump (fichier générer par mysqldump et qui aura le même effet)

* étape 3 (optionnel): déplacer le fichier mysql_config.php dans un endroit sécurisé

* étape 4 (optionnel): si vous avez déplacer votre fichier mysql_config.php,vous devrait changer son chemin d'accès dans
le fichier index.php: 
require_once('mysql_config.php') devient alors require_once('/chemin/vers/fichier/mysql_config.php');



