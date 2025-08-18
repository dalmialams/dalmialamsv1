# Install Podman / Docker 
docker --version

# Build the GeoServer Image
docker build --no-cache --network host -t lams/geoserver:2.0 -f Dockerfile.geoserver .

# Build the AppServer Image
docker build --no-cache --network host -t lams/appserver:1.0 -f Dockerfile.appserver .

# Run the GeoServer
docker run -d \
-v /data/volumes/geoserver_data/workspaces:/opt/geoserver_data/workspaces \
-v /data/volumes/config/web.xml:/usr/local/tomcat/webapps/geoserver/WEB-INF/web.xml \
--name geoserver \
--network host \
lams/geoserver:1.0 

# Run the AppServer
docker run -d \
--name lms-application \
--network host \
-v /data/volumes/uploads:/var/www/html/assets/uploads \
-v /data/volumes/config/environments/.env.qa:/var/www/html/.env \
-v /data/volumes/config/ssl/dalmia.pem:/etc/apache2/ssl/dalmia.pem \
-v /data/volumes/config/v_hosts/gateway.conf:/etc/apache2/sites-available/000-default.conf \
lams/appserver:2.0