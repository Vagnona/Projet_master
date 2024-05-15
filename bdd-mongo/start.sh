docker compose -f cf-primary down

docker compose -f cf-primary up -d

sleep 5

docker exec mongo1 /scripts/rs-init.sh

sleep 20

docker exec mongo1 /scripts/add-data.sh
