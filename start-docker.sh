docker run -e MYSQL_ROOT_PASSWORD=password -p 3306:3306 -d mysql:latest
docker run --name camagru -d -v ${PWD}:/app php:latest

docker exec -it /bin/bash camagru

# Run the commands in setup file to complete
