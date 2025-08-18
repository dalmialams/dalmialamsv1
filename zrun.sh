docker rm lms-appserver -f 

docker build --no-cache --network=host -t lams/appserver:1.0 -f appserver . 

docker run -d --name lms-appserver --network host -p 80:80 -p 443:443 -v /data/uploads:/var/www/html/assets/uploads    --restart always lams/appserver:1.0

docker ps
