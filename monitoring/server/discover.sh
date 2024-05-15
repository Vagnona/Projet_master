#!/bin/bash


# Supprimez le fichier existant
rm targets.json

echo "[" >> targets.json
echo "  {" >> targets.json
echo "    \"labels\": {" >> targets.json
echo "      \"job\": \"monitor\"" >> targets.json
echo "    }," >> targets.json
echo "    \"targets\": [" >> targets.json


# Recherchez tous les nodes_exporter en cours d'exécution
for host in $(nmap -p 9100 --open 192.168.0.0/24 -oG - | grep "Up" | cut -d ' ' -f 2); do
	echo "      \"$host:9100\"," >> targets.json
done

# Recherchez tous les nodes_exporter en cours d'exécution
for host in $(nmap -p 9100 --open 10.0.0.0/24 -oG - | grep "Up" | cut -d ' ' -f 2); do
	echo "      \"$host:9100\"," >> targets.json
done

# Supprimez la dernière virgule
sed -i '$ s/.$//' targets.json

echo "    ]" >> targets.json
echo "  }" >> targets.json
echo "]" >> targets.json
