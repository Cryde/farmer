# Farmer API

Farmer API game

[![codecov](https://codecov.io/gh/Cryde/farmer/graphs/tree.svg?token=G5IQXFBPV3)](https://codecov.io/gh/Cryde/farmer)

[![codecov](https://codecov.io/gh/Cryde/farmer/graph/badge.svg?token=G5IQXFBPV3)](https://codecov.io/gh/Cryde/farmer)


### Installing

#### Setup local https

The application need to be run in HTTPS
Go to the root project, then launch :
```
./bin/create_ssl_ca
./bin/create_ssl_cert farmer.local
```

You will only need to run this once


#### Setup Docker

You will need Docker to run this project.
Follow the Docker installation guide (https://docs.docker.com/get-docker/) to have it on your environment.

Go in the project root and run
```
docker compose up -d
```
It will pull and build all the required images to run Farmer API game

If you need to rebuild image (after an update for instance)
``` 
docker compose up --build
```


#### Setup the project

Add `farmer.local` to your `/etc/hosts`
```
10.100.200.2 	farmer.local
```