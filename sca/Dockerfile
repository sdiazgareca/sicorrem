FROM eugeneware/php-5.3
#ENV TZ=America/Santiago
ENV TZ=America/New_York
COPY . /var/www/html
WORKDIR /var/www/html
EXPOSE 80

# docker build -t sca-image .   
# docker run -p 8081:80 --name sca sca-image
# docker run -d -p 8081:80 -e TZ=America/New_York --name sca sca-image