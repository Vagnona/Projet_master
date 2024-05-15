job "mongo" {
  datacenters = ["dc1"]

  group "primary" {
    count = 1

    network {
      port "http" {
	to = 27017
      }
    }

    task "mongo" {
      driver = "docker"
      config {
        image = "mongo:7.0.2"
	args = ["--replSet", "rs0", "--bind_ip_all"]
	ports = ["http"]
	volumes = [
		"local:/var"
	]
      }
            
			service {
				name = "mongo"
				port = "http"
			}
	
	template {
		data = <<EOF
var config = {
	"_id": "rs0",
	"version": 1,
	"members": [
		{{ range service "mongo" }}
		{
			"_id": {{ .Port }},
			"host": "{{ .Address }}:{{ .Port }}",
			"priority": 1
		},
		{{ end }}
	]
};
EOF
		destination = "local/initiate.js"
		change_mode = "script"
		change_script {
			command = "/var/initiate.sh"
		}
	}

	template {
		data = <<EOF
#!/bin/bash
# vérifier que le réplica set est déja configuré
if [[ $(mongosh --quiet --eval "rs.status().ok") == "1" ]]; then
	echo "rs.reconfig(config)" >> /var/initiate.js
else
	echo "rs.initiate(config)" >> /var/initiate.js
fi
cat /var/initiate.js | mongosh
# suppression de la dernière ligne du fichier
sed -i '$ d' /var/initiate.js
EOF
		destination = "local/initiate.sh"
		perms = "777"
	}

      
      resources {
        cpu    = 200
        memory = 256
      }
    }


}

	group "secondary" {
	    count = 2

	    network {
	      port "http" {
		to = 27017
	      }
	    }
    task "mongo" {
      driver = "docker"
      config {
        image = "mongo:7.0.2"
	args = ["--replSet", "rs0", "--bind_ip_all"]
	ports = ["http"]
      }
            
			service {
				name = "mongo"
				port = "http"
			}
	      resources {
		cpu    = 200
		memory = 256
	      }
	}
	    scaling {
	      enabled = true
	      min = 1
	      max = 6
	    }
    }
}

