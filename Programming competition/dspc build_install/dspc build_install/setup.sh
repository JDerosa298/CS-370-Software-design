#!/bin/bash
cd ~
sudo apt install nautilus-admin
sudo nautilus -q
sudo apt-get remove docker docker-engine docker.io
sudo apt-get update
sudo apt-get install \
    apt-transport-https \
    ca-certificates \
    curl \
    software-properties-common
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
sudo add-apt-repository \
   "deb [arch=amd64] https://download.docker.com/linux/ubuntu \
   $(lsb_release -cs) \
   stable"
sudo apt-get update
sudo apt-get install docker-ce apache2 php openjdk-11-jdk
docker pull derosajm/pycontainer
pycontainer1=$(docker container create -it derosajm/pycontainer bash)
docker rename $pycontainer1 pycontainer
docker pull derosajm/c_container
C_container1=$(docker container create -it derosajm/c_container bash)
docker rename $C_container1 c_container
mkdir dspc
cd dspc
wget http://www.dropbox.com/s/f2kdeqw38t4m877/server.jar
cd ..
chmod a+rw dspc
cd dspc
java -jar server.jar
