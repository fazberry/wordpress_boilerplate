# Wordpress Boilerplate
## Basic wordpress theme using twig

### Getting started
* Install Node.JS
* Fork repository to a new one with the project name
* Clone to your local machine
* Open CMD/Terminal and traverse to GIT folder
* Run `npm install` to download dependencies
* Run `gulp` to start

All files should go within `src` and only files in the `dist` folder should be uploaded to the server.

Gulp will do the following tasks:
* Copy plain CSS to dist folder
* Parse and copy SASS to dist folder, ignoring those with _
* Copy minified JS to dist folder
* Lint, minify and move JS files

It will watch for any new changes and re-run the above steps if needed


### Starting new project
* Create a repository -> check the checkbox
* In Bash - git clone 
* `git pull https://github.com/fazberry/wordpress_boilerplate.git --allow-unrelated-histories`
