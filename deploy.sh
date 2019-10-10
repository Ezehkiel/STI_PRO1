docker run -p 8080:80 -v "$PWD/site":/usr/share/nginx --env TZ=Europe/Zurich --name sti_project -d -t -i arubinst/sti:project2018 
docker exec -u root sti_project service nginx start
docker exec -u root sti_project service php5-fpm start
docker exec -u root sti_project sudo chgrp www-data /usr/share/nginx/databases/sti_project.sqlite
docker exec -u root sti_project sudo chgrp www-data /usr/share/nginx/databases/
docker exec -u root sti_project sudo chmod g+w /usr/share/nginx/databases/
docker exec -u root sti_project sudo chmod g+w /usr/share/nginx/databases/sti_project.sqlite
