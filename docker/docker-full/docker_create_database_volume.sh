#!/bin/bash
DOCKER_MYSQL_VOLUME=aml87-mysql-volume

if ! docker volume inspect $DOCKER_MYSQL_VOLUME >/dev/null; then
		echo -e "\033[0;31m Le volume '$DOCKER_MYSQL_VOLUME' n'existe pas. \033[0m"
		if docker volume create $DOCKER_MYSQL_VOLUME >/dev/null; then
		  		echo -e "\033[0;32m Le volume '$DOCKER_MYSQL_VOLUME' a été créé avec succès. \033[0m"
    else
      echo -e "\033[0;31m Erreur survenue pendant la création du volume '$DOCKER_MYSQL_VOLUME'. \033[0m"
		  exit 1
		fi
else
  	echo -e "\033[0;33m Le volume '$DOCKER_MYSQL_VOLUME' existe déjà. \033[0m"
fi
exit 0
