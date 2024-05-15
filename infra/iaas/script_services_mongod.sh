for i in {1..3}; do
	fichier="/etc/systemd/system/mongod$i.service"
	echo "[Unit]" >> $fichier
	echo "Description=Mongo DB Instance $i" >> $fichier
	echo -e "After=network.target\n\n[Service]" >> $fichier
	echo "ExecStart=/bin/mongod --replSet rs0 --bind_ip_all --port 3000$i --dbpath /data/mongo$i/" >> $fichier
	echo -e "StandardOutput=syslog\nStandardError=syslog\n\n[Install]\nWantedBy=multi-user.target" >> $fichier
	systemctl enable mongod$i
	systemctl start mongod$i
done
