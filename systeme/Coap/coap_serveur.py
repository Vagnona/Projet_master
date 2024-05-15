#!/usr/bin/env python

import getopt
import sys
from coapthon.server.coap import CoAP

from Ressources_serveur.ressources import Basic

class CoAPServer(CoAP):
    def __init__(self, host, port, multicast=False, file="sortie.txt"):
        CoAP.__init__(self, (host, port), multicast)
        self.file = file 
        self.add_resource('basic/', Basic(file))
        
        print("CoAP Server start on " + host + ":" + str(port))
        print(self.root.dump())


def usage():  # pragma: no cover
    print("coapserver.py -i <ip address> -p <port>")


def main(argv):  # pragma: no cover
    ip = "0.0.0.0"
    port = 5683
    multicast = False
    file = "sortie.txt"
    try:
        opts, args = getopt.getopt(argv, "hi:p:mf:", ["ip=", "port=", "multicast","file"])
    except getopt.GetoptError:
        usage()
        sys.exit(2)

    for opt, arg in opts:
        if opt == '-h':
            usage()
            sys.exit()
        elif opt in ("-i", "--ip"):
            ip = arg
        elif opt in ("-p", "--port"):
            port = int(arg)
        elif opt in ("-m", "--multicast"):
            multicast = True
        elif opt in ("-f", "--file"):
            file = arg

    server = CoAPServer(ip, port, multicast, file)
    try:
        server.listen(10)
    except KeyboardInterrupt:
        print("Server Shutdown")
        server.close()
        print("Exiting...")


if __name__ == "__main__":  # pragma: no cover
    main(sys.argv[1:])
