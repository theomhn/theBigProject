# TheBigProject | Documentation fonctionnelle

Projet de fin d'année de Bachelor SUPDEWEB 3 Développement

---

## **Introduction :**
...

---

## **Objectif :**
...

---

## **Fonctionnalités :**

- ...
- ...
- ...
- ...
- ...
- ...

---

## **Technologies utilisées :** 
  
Les languages / technologies utilisé(e)s pour développer theBigProject :
- **Serveur local** : (MAMP ou LAMP)
- **Back-end** : PHP 8.2
- **Base de données** : MySQL
- **Front-end** : HTML5 / SCSS / VanillaJS

### **Motivation :**

J'ai choisi ces technologies pour avoir des vraies base dans la langages fondamentaux avant de me lancer dans les différents framework. De plus je les utilise dans mon travail ce qui me permet d’étoffer mes connaissances et de pouvoir recevoir de l'aide plus facilement de la par de mes collègues développeur.

---

## **Diagramme de cas d'utilisation :**
...

 Diagramme de cas d'utilisation

---

## **Conclusion :**
...

---

# **Note**

## Recommendations
- 1.0 Modélisation de la BDD
- 1.1 Modélisation des Use-Case et implémentation


## API
- 1.0 Back
 - Model :
   -  les classes et leurs fonctions
 - Controller :
   -  vérification de la sécurité pour pour accéder aux aux fonctions des méthodes
 - Router :
   - associer une URL et une méthode (PUT, GET, POST, DELETE) à une fonction du contrôleur

- 2.0 Front
   - Fonction AJAX générique qui prend en paramètre l'url, la méthode, les données, les headers -> fetch()
   - Une classe avec toutes les fonctions possible de l'API
     - Des sous classes par type d'obj
       - ex : monAPI = new API("www.mon-site.fr/ws")
              await lesUsers = monAPI.users.getALL()
              await unUser = monAPI.users.get(id)
---