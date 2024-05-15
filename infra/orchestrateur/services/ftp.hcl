job "sftp" {
  datacenters = ["dc1"]
  type = "system"


  group "sftp" {
    count = 1

    task "insert" {
      driver = "docker"
      config {
        force_pull = true
        image = "registry.app.unistra.fr/fseel/projet-master-23-24/sftp_updater"

        volumes = [
          "/upload:/upload"
        ]
      }

      template {
	data = "MONGODB_URL=\"mongodb://{{ $services := service \"mongo\" }}{{ range $index, $service := $services }}{{ .Address }}:{{ .Port }}{{ if ne (add $index 1) (len $services) }},{{ end }}{{ end }}\""
	destination = "/mongo.env"
	env = true
      }
    
      resources {
        cpu    = 200
        memory = 256
      }
    }
	}
}
