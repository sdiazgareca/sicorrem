# Nombre del script: deploy-sicoremm.ps1

# Construir la imagen de Docker
docker build -t sicoremm-image .

# Detener el contenedor si está en ejecución
docker stop sicoremm2

# Eliminar el contenedor si existe
docker rm sicoremm2

# Ejecutar un nuevo contenedor con el puerto mapeado
docker run -p 8081:80 --name sicoremm2 sicoremm-image
