#!/bin/bash

mongosh --port 30001 <<EOF
var config = {
    "_id": "rs0",
    "version": 1,
    "members": [
        {
            "_id": 1,
            "host": "mongo1:30001",
            "priority": 2
	}]
};
rs.initiate(config, { force: true });
rs.status();
exit;
EOF

#db.createUser({user: 'admin', pwd: 'admin', roles: [ { role: 'root', db: 'admin' } ]});
