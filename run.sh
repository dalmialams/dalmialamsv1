# podman network create dalmia-lms
# Build Geo Server 
podman build -t lms-geoserver -f ./Dockerfile.geoserver
# Build App Server 
podman build -t lms-appserver -f ./Dockerfile.application

# Run the Servers 

podman run -dt --name lms-geoserver --network dalmia-lms  lms-geoserver:latest
podman run -dt --name lms-appserver --network dalmia-lms -p 443:443 lms-appserver:latest