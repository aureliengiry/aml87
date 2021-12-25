FROM node:14-stretch-slim

COPY . /usr/local/docker
RUN chmod -R 777 /usr/local/docker

RUN apt-get update \
&& apt-get install -y python make g++ vim

ENTRYPOINT ["/usr/local/docker/run.sh"]
