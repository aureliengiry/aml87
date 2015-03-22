#!/usr/bin/env sh

################## START MIGRATION ##################
echo "Create database schema"
php app/console doctrine:schema:update --force

################ Create admin user ##################
php app/console fos:user:create admin aurelien.giry@gmail.com passwordtest --super-admin

################ Migration ##################
# Import Page (content_type=association)
php app/console migration:import:pages -vvv

# Import Blog
php app/console migration:import:blog-categories -vvv
php app/console migration:import:blog-tags -vvv
php app/console migration:import:blog-images -vvv
php app/console migration:import:blog-videos -vvv
php app/console migration:import:blog-articles -vvv

# Import links
php app/console migration:import:links -vvv

# Import Discography
php app/console migration:import:discographie -vvv

# Import agenda
php app/console migration:import:evenements -vvv
php app/console evenements:index:seasons -vvv

# Clear cache
php app/console cache:clear
php app/console cache:clear --env=prod