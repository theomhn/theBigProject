# TheBigProject | Documentation d'installation de l'application

Cette documentation vous guide à travers le processus d'installation de l'application theBigProject sur un serveur local.

---

## **Prérequis**

Assurez-vous que les éléments suivants sont installés sur votre serveur :

- Serveur local permettant d'exécuter du PHP type **([MAMP](https://www.mamp.info/en/downloads/)) ou ([WAMP](https://www.wampserver.com/en/download-wampserver-64bits/))**
- PHP version 8.2 ou supérieure
- MySql 5.7.39 / phpMyAdmin  5.2.1
- ([Git installé du votre machine](https://git-scm.com/downloads))

---

## **Étape 1 : Télécharger l'application**
Téléchargez le package d'installation de l'application depuis mon github.

Rendez-vous dans le dossier du serveur local:

**Sur MacOS :**
```
Applications/MAMP/htdocs/
```

**Sur Windows :**

- Avec WAMP
    ```
    C:\wamp64\www\
    ```
- AVEC MAMP
    ```
    C:\MAMP\htdocs\
    ```

Ouvrez un terminal dans ce dossier puis exécuter la commande suivante :

```shell
git clone https://github.com/theomhn/theBigProject.git
```
---
<!-- 
## **Étape 2 : Extraire les fichiers**
Extrayez les fichiers zippés préalablement téléchargé dans le dossier cité ci-dessus en fonction de votre machine.

--- -->

## **Étape 2 : Importer la base de données**
1. Dans le dossier que vous avez cloné, vous trouverez un fichier nommé **theBigProject.sql**.
2. Lancer votre serveur (WAMP ou MAMP) puis rendez-vous sur votre gestionnaire de bases de données **phpMyAdmin** accessible de votre navigateur favori.
3. phpMyAdmin est accessible à une adresse qui devrait être similaire à celle ci-dessous : 
    ```
    http://localhost/phpmyadmin
    ```
<!-- 4. Créez une nouvelle bdd nommé **theBigProject** encodé en **utf8mb4_general_ci** -->
5. Puis importé le fichier **theBigProject.sql**

---

## **Étape 3 : Utiliser l'application**

Rendez dans un nouvel onglet de votre navigateur pour tester l'application et saisissez : 

**Pour Windows :**
```
localhost/theBigProject/
```

**Pour Mac**
- si vous utilisez le port par défaut de MAMP : 
    ```
    http://localhost:8888/theBigProject/
    ```
- Si vous utilisez le port 80
    ```
    http://localhost/theBigProject/
    ```