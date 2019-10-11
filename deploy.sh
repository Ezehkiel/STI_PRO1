#!/bin/bash
#
# usage: ./deploy.sh
#
# This script is used to deploy the container for the STI Project.

# Clean instance
docker stop sti_project
docker rm sti_project

# Start the container
docker run -p 8080:80 -v "$PWD/site":/usr/share/nginx --env TZ=Europe/Zurich --name sti_project -d -t -i arubinst/sti:project2018 

# Make some commands to start all services and adapt right on database files
docker exec -u root sti_project service nginx start
docker exec -u root sti_project service php5-fpm start
docker exec -u root sti_project sudo chgrp www-data /usr/share/nginx/databases/sti_project.sqlite
docker exec -u root sti_project sudo chgrp www-data /usr/share/nginx/databases/
docker exec -u root sti_project sudo chmod g+w /usr/share/nginx/databases/
docker exec -u root sti_project sudo chmod g+w /usr/share/nginx/databases/sti_project.sqlite
