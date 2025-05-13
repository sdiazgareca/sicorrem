@echo off


REM Stop and remove the container
docker stop sicoremm
docker rm sicoremm

REM Delete the image
docker rmi sicoremm-image

REM Build the new image
docker build -t sicoremm-image .

REM Run the container
docker run -p 8080:80 --name sicoremm sicoremm-image