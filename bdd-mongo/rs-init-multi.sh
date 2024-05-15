#!/bin/bash

mongosh --port 30001 <<EOF
var config = {
    "_id": "rs0",
    "version": 1,
    "members": [
        {
            "_id": 1,
            "host": "10.0.0.2:30001",
            "priority": 2
        },
        {
            "_id": 2,
            "host": "10.0.0.3:30001",
            "priority": 1
        },
        {
            "_id": 3,
            "host": "10.0.0.4:30001",
            "priority": 1
        },
        {
            "_id": 4,
            "host": "10.0.0.5:30001",
            "priority": 1
        },
        {
            "_id": 5,
            "host": "10.0.0.6:30001",
            "priority": 1
        },
        {
            "_id": 6,
            "host": "10.0.0.7:30001",
            "priority": 1
        },
        {
            "_id": 7,
            "host": "192.168.2.3:30001",
            "priority": 1
        }
    ]
};
rs.initiate(config, { force: true });
rs.status();
exit;
EOF

#db.createUser({user: 'admin', pwd: 'admin', roles: [ { role: 'root', db: 'admin' } ]});
