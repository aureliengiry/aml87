FROM node:stretch-slim

COPY . /usr/local/docker
RUN chmod -R 777 /usr/local/docker

RUN apt-get update --fix-missing && apt-get install -y python make g++ vim \
&& npm install socket.io -g \
&& npm install forever -g \
&& npm install forever-monitor \
&& npm install -g yarn

ENTRYPOINT ["/usr/local/docker/run.sh"]
