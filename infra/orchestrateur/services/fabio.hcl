job "fabio" {
  datacenters = ["dc1"]
  type = "system"

  group "fabio" {
    network {
      port "lb" {
        static = 9999
      }
      port "ui" {
        static = 9998
      }
    }
    task "fabio" {
      driver = "docker"
      config {
        image = "fabiolb/fabio"
        network_mode = "host"
        ports = ["lb","ui"]
	volumes = ["fabio:/etc/fabio", "var:/var"]
      }

      template {
	data = <<EOF
proxy.cs = cs=mine;type=file;cert=/var/example-com.crt;key=/var/example-com-privateKey.key
proxy.addr = :9999;proto=https;cs=mine
EOF
	destination = "fabio/fabio.properties"
      }

      template {
      	data = <<EOF
-----BEGIN CERTIFICATE-----
MIIDhjCCAm6gAwIBAgIEDUMhJDANBgkqhkiG9w0BAQsFADBbMScwJQYDVQQDDB5SZWdlcnkgU2Vs
Zi1TaWduZWQgQ2VydGlmaWNhdGUxIzAhBgNVBAoMGlJlZ2VyeSwgaHR0cHM6Ly9yZWdlcnkuY29t
MQswCQYDVQQGEwJVQTAgFw0yNDAxMjAwMDAwMDBaGA8yMTI0MDEyMDIzMTkwOFowSDEUMBIGA1UE
AwwLZXhhbXBsZS5jb20xIzAhBgNVBAoMGlJlZ2VyeSwgaHR0cHM6Ly9yZWdlcnkuY29tMQswCQYD
VQQGEwJVQTCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAMdvnWW7FO5LJYboPYvCnGgI
lx1SWQhIcWeCdtd/YZ7g2Y1tE6JV5pplzoGrAe78lm62uYAyRL37IZ6lNn1kWRhut4csoC5GOEzR
Z0DoU2YchJdtmjh36Pzb8/t9tKZQyFhzRaYoJE83FqmLKhnxknmnvB3XhGyH/uEq9q5dt+FI3EP6
fk8g78XzwqvBz0hPykrnYE9kch9HySDxb+6MlIMKJlf8rhz1QqidP1Gl0LtJnwH7bdguryHw2ozD
JcakHHB+GiQ0M1YgFlo8UK2d3mDmhQ0qbx6lIkZdTcnEE9jB6kW5Pfy4mHpcR77748vhCHxZS19y
oEw70nrzMCrzLMsCAwEAAaNjMGEwDwYDVR0TAQH/BAUwAwEB/zAOBgNVHQ8BAf8EBAMCAYYwHQYD
VR0OBBYEFK3Gh1YUf8Y7H3joJRtY6/IXl2e2MB8GA1UdIwQYMBaAFK3Gh1YUf8Y7H3joJRtY6/IX
l2e2MA0GCSqGSIb3DQEBCwUAA4IBAQCGidnfmL33Lu/CcZUiIE9nXmvicdAa5ysRf2EZ5ai+1Wru
tvIjNC3lBLECjQqX/rRV+cgMHCdsP2+O3Xt4qqnLDQCtuv4yEOPCMOx3LRbC2wi/EbZzGHDO4QVC
q3x4OJ0UryolzMXv1kMh9UhrNPDVYx0u+0uHrrwLvHJL4Noo/ZtgdBEHkiVIygHG2yCOzqX9WVsB
U2FrsWtA+t6pWd26+uwOXXU8xt2FvjGCkYBUPMYV9OaQBz3bKEbCfZMFZ0aBHXFU0QGoOjK1GAPX
IgYZ2rUEwiuPGs4+HXqIgFotHXcoeMDDTf3CpOrEYhNR/gJpBiku1ulMFqPx93W32i4K
-----END CERTIFICATE-----
EOF
	destination = "var/example-com.crt"
      }

      template {
      	data = <<EOF
-----BEGIN RSA PRIVATE KEY-----
MIIEpQIBAAKCAQEAx2+dZbsU7kslhug9i8KcaAiXHVJZCEhxZ4J2139hnuDZjW0T
olXmmmXOgasB7vyWbra5gDJEvfshnqU2fWRZGG63hyygLkY4TNFnQOhTZhyEl22a
OHfo/Nvz+320plDIWHNFpigkTzcWqYsqGfGSeae8HdeEbIf+4Sr2rl234UjcQ/p+
TyDvxfPCq8HPSE/KSudgT2RyH0fJIPFv7oyUgwomV/yuHPVCqJ0/UaXQu0mfAftt
2C6vIfDajMMlxqQccH4aJDQzViAWWjxQrZ3eYOaFDSpvHqUiRl1NycQT2MHqRbk9
/LiYelxHvvvjy+EIfFlLX3KgTDvSevMwKvMsywIDAQABAoIBAElp1EI4+iz3u5Is
Fk/GrSV8mAfiosRySlCEjXOpP8mo0lyFnPcicNdAB6LizLzo/QU3PRSsLHLUqV0J
SwQgds2QH/3h1vsBvULFyKDzhJOvhr1pSp5jwX+nBep7LQ8V6JHqqOZPm4IPcMer
Yy2Wp8khjhVcGrKK4y+GzbSE6iXCsYupxKEQVW7wcc4duhcSe4PgztOMQmhS3e18
MwRzK6B1hzZatZyPRzm4bNEEe2b/shd+PD24UoJR04hNL1leLHVfkRpnMYnq1T4h
U8EMtWGDSIlKCJ9mRPhvXNoCa1ObpRRC7CkwQwDk1WwAnMVmzCdud9soYlbz+kwI
e7SMj5ECgYEA+0UHbuP5kk6mQyFZr+Ki3m1ODD4R174C3a/mwobnzw1victGpogv
8mrt2cH8YE9GdEDNn85AKoI1Y5c1Am74jDWiZ/L1v2g80+3X/fqQs6tLrwd7ZdvL
oEZibLLVZ6rIvSG6l7p2aRaSQ7d2q4ymTkM6Lo7aSrRgALgM5G9uUlECgYEAyzDH
PeN9a4i9KWO7euMq7vMkdIT/v3znfgmPqCaIt/yPlZAqfLhOD/YKCRTfJTkPRML9
c1TGWGi9Q9IJLEFy/qSwBjG6nAIWm34POs2pFCr/2lGzBu6+O2YOD+CoBFBoibkA
yIBXtsw26KiP3Dpqkxs0wdhrJ8jZYaDT+OtIylsCgYEAzvHTZWktq2pLVQ6qp0mp
ijfMCBk26ND920d8bspdMRKHwp1A2vdfRfD7ZFV4XnnsNOMKd4uPHXOQNS3b4t0y
p4ek8qgP7k0TjBhfxDYR52g1NTqcTw/vbVmKxqujR3ZJTjvxSfWwgGyumkcH3dJB
RkPoL2BIOS7FwtHTDHEaE4ECgYEAhHbfXXyCVmmFkIchQUL5yV+fw4q1RDwEmslW
6zN77B5t6P5chISO957Z+gOuWhDx4E0SeG6rBBX8VUuHiV99vX7V9qPS2UQPQv2S
pi5PbQN/Wu/qO7nHMOgegMFgJ7fX/vkqBoyNInHN1i2V4+f9dLvG0Bzr9rrc5OW5
a0zQXoMCgYEA106mw/wjwHmPkZKwmKHk7C93wRqEQJaae9BLmv9fGsmMnS7cVUrw
3IbjpLEqnGXtNHiOfo6w8m7BdGMhGsUqu7E2B7Zc0H6nSPTeJlr3XVkvVDsZ87QV
fMaV+GL39MC+WDYI9AUXGaoE1obaM+oS1AZ8oQaLOOQsV1TF+QodNUk=
-----END RSA PRIVATE KEY-----
EOF
	destination = "var/example-com-privateKey.key"
      }	

      resources {
        cpu    = 200
        memory = 128
      }
    }
  }
}

