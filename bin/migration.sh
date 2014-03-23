#!/usr/bin/env sh

################## START MIGRATION ##################
echo "Create database schema"
php app/console doctrine:schema:update --force

################ Create admin user ##################
php app/console fos:user:create admin aurelien.giry@gmail.com passwordtest --super-admin

################ Migration ##################
php app/console migration:import:blog-categories -vvv    # Import Blog Categories from old website
php app/console migration:import:blog-tags -vvv          # Import Blog tags from old website
php app/console migration:import:blog-images -vvv        # Import Blog images from old website
php app/console migration:import:blog-videos -vvv
php app/console migration:import:blog-articles -vvv      # Import Blog articles from old website

php app/console migration:import:links -vvv

php app/console migration:import:discographie -vvv

php app/console migration:import:evenements -vvv