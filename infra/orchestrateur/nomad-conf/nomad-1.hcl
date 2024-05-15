datacenter = "dc1"
data_dir  = "/opt/nomad/data"
name = "nc1"

bind_addr = "0.0.0.0"

advertise {
  http = "{{ GetInterfaceIP `vxlan100` }}"
  rpc = "{{ GetInterfaceIP `vxlan100` }}"
  serf = "{{ GetInterfaceIP `vxlan100` }}"
}

server {
  enabled          = true
  bootstrap_expect = 5
}

client {
  enabled = true
  network_interface = "vens4"

  host_network "internal"{
    interface = "vens4"
    cidr = "10.3.0.1/16"
  }
  host_network "public"{
    interface = "vens4"
    cidr = "10.3.0.6/16"
  }
}
# Authentification docker
plugin "docker" {
  config {
    auth {
      config = "/root/.docker/config.json"
    }
    volumes {
      enabled = true
    }
  }
}

telemetry {
  collection_interval = "1s"
  disable_hostname = true
  prometheus_metrics = true
  publish_allocation_metrics = true
  publish_node_metrics = true
}
