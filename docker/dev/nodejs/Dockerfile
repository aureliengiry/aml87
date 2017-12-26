FROM node:6.11

COPY . /usr/local/docker
RUN chmod -R 777 /usr/local/docker

RUN apt-get update && apt-get install -y \
        vim

RUN npm install socket.io -g
RUN npm install forever -g
RUN npm install forever-monitor
RUN npm install forever-monitor
RUN npm install -g yarn

ENTRYPOINT ["/usr/local/docker/run.sh"]
