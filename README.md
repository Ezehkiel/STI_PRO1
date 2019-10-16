# STI_PRO1
Author: Antoine Hunkeler, Rémi Poulard

During this project we had to set up a website to exchange messages between different people. The constraint was that we should not focus on the security aspect.

# Install

## Prerequisites
1. You need to have docker to run this project

## Install
1. Clone the repository
2. Goes in the folder that you just cloned.
3. Execute the script `deploy.sh` 
4. Go on [localhost:8080/login.php](localhost:8080/login.php) Note: sometimes localhost doesn't match 
so you have to find the ip of the container and replace localhost by this ip 
(`docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' sti_project`)
5. There are two user: `admin:admin` and `test:test`. Both are administrator
