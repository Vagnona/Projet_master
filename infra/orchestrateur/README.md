# Installer consul/nomad

## Installation
```bash
sudo apt-get update && \
  sudo apt-get install wget gpg coreutils

wget -O- https://apt.releases.hashicorp.com/gpg | sudo gpg --dearmor -o /usr/share/keyrings/hashicorp-archive-keyring.gpg

echo "deb [signed-by=/usr/share/keyrings/hashicorp-archive-keyring.gpg] https://apt.releases.hashicorp.com $(lsb_release -cs) main" | sudo tee /etc/apt/sources.list.d/hashicorp.list

sudo apt-get update && sudo apt-get install nomad consul docker

sudo apt update
sudo apt install apt-transport-https ca-certificates curl gnupg

curl -fsSL https://download.docker.com/linux/debian/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker.gpg

echo "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker.gpg] https://download.docker.com/linux/debian bookworm stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

sudo apt update

sudo apt install docker-ce docker-ce-cli containerd.io docker-buildx-plugin

sudo apt install keepalived
```

## Configuration de consul

Each configuration of consul is in this folder. Copy the right one to `/etc/consul.d/consul.hcl`.

```bash
sudo cp consul-X.hcl /etc/consul.d/consul.hcl
```

## Configuration de nomad

Each configuration of nomad is in this folder. Copy the right one to `/etc/nomad.d/nomad.hcl`.

```bash
sudo cp nomad-X.hcl /etc/nomad.d/nomad.hcl
```

## Configuration des services

Consul service is in this folder. Copy it to `/etc/systemd/system/consul.service` and reload systemd.

```bash
sudo cp consul.service /etc/systemd/system/consul.service
sudo systemctl daemon-reload
```

## Configuration de keepalived

Keepalived configuration is in this folder. Copy it to `/etc/keepalived/keepalived.conf` and reload keepalived.

```bash
sudo cp keepalived.conf /etc/keepalived/keepalived.conf
sudo systemctl enable keepalived
```

## Démarrage des services

```bash
sudo systemctl start consul
sudo systemctl start nomad
sudo systemctl start keepalived
```

## Login on docker

```bash
sudo docker login registry.app.unistra.fr
# Enter your credentials (use an access token instead of your password)
```

## Vérification du bon fonctionnement
 
Consul/Nomad should be accessible on `http://localhost:8500` and `http://localhost:4646` respectively.