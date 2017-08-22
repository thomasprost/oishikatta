Oishikatta Documentation
========================

Welcome to the Oishikatta. Version number : 1.0.0
The purpose of this documentation is just to explain quickly what technologies are used, 
how to use and compile them.

I wanted to create an app that helps me saving my recipes and 
at the same time learn more about some technologies (mostly Php and Js)

If you happen to stumble on this project, 
it's a work in progress. I'll update this documentation when it's more advanced.

If you want to understand more about Symfony and its structure, 
go check [symfony.com][1] or  their [github][2]

Each part of the project has comments and hopefully will be useful (Controllers, Repositories, Js, ...). 


What's inside?
--------------

The Symfony Standard Edition is configured with the following defaults:

  * An AppBundle you can use to start coding;

  * Twig as the only configured template engine;

  * Doctrine ORM/DBAL;

  * Swiftmailer;

  * Annotations enabled for everything.

Different bundles and technologies have been installed to add more features : 

  * **Composer** - Manages PHP dependencies

  * **Doctrine Migrations** - Helps migrating database easily with keeping migration diff (in app/doctrineMigrations).
  See [Migrations Usage][3]

  * [**VichUploader**][4] - Manages image upload

  * [**Sass**][5] - Stylesheets were created in SASS (Scss format), 
  Check documentation online to install it if you don't have it. 

  * [**Webpack**][6] - JavaScript task runner to automate different things (minify css, js, images among others)
  See package.json for grunt dependencies and Gruntfile.js for configuration. Each tasks are explained inside.
  We use Symphony's environments to know if we should use dev files or distribution ones. 
  web/dist directory hosts the distribution files (Minified css, images and js. Fonts)
  
  * [**Vue.js 2**][7] - Vue is a progressive framework for building user interfaces. I'm still learning it so this part of the documentation will evolve when I know more about it.
  I will use both Twig and Vuejs for templating
  
  * Git - For now everything is on master branch but I will separate master and develop if I set up a test website. 
  Usually I follow [**this**][8]
  
  * When possible, keep Entity queries in their respective repositories and query data with ArrayResults, it's way way faster than Object queries.
  Be careful that limit (Doctrine's maxresults) has a weird (and broken) behaviour with ArrayResult. See Doctrine Documentation.

Installation
--------------

#### PHP
After pulling the website from git and installing the different technologies (php, ruby, sass, ...), you should :
```
    php composer install
```
 If you add new php dependencies or bundles : 
```
    php composer update
``` 
 
 Configure parameter.yml with your database and smtp settings
 Install database : 
```
    php bin/console doctrine:database:create
    php bin/console doctrine:schema:update --force
``` 
  
  When making changes to database, use database migration, not schema update
  
```
doctrine:migrations
  :diff     Generate a migration by comparing your current database to your mapping information.
  :execute  Execute a single migration version up or down manually.
  :generate Generate a blank migration class.
  :migrate  Execute a migration to a specified version or the latest available version.
  :status   View the status of a set of migrations.
  :version  Manually add and delete migration versions from the version table.
```
  
  For cleaning cache in Symfony use : 
```
    php bin/console cache:clear
``` 
  
  And for dist environment : 
```
    php bin/console cache:clear --env=prod
``` 

It usually fixes many problems to clear the cache (add translations, ...) 

#### Npm and Webpack

For modules and task running, Webpack is installed with different modules and loader

First you need to install node, npm and then dependencies :

```
    npm install
```

For dev environment, you can just use :
```
    npm run dev
```
It will watch for changes in scss and files
In dev environment, it injects the css directly in the page

On production, you need to run : 

```
    npm run prod
```

It will run each steps needed by the prod environment, check js and compile everything

I still need to add some loaders and modules.

Dist folder is ignored by git


If you add new features, dependencies or stuffs :), document and comment it please.
you can refer to **Symfony**'s documentation anytime you get lost.

Enjoy!

[1]:  https://symfony.com
[2]:  https://github.com/symfony/symfony
[3]:  https://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html#usage
[4]:  https://github.com/dustin10/VichUploaderBundle/
[5]:  http://sass-lang.com/
[6]:  https://webpack.github.io/
[7]:  https://vuejs.org/
[8]:  http://nvie.com/posts/a-successful-git-branching-model/

