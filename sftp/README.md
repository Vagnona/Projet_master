Run two docker : one for the server and one for the update script

the first server is simply a sftp server with a user and a password, with a volume to store the files
the second is a script that will update the files in the volume.
Use full path
```
# Run server
docker run -p 2222:22 -v <full_path>/upload:/home/sftp_user/upload -d atmoz/sftp sftp_user:pass:1001
# Build and run updater
docker build -t registry.app.unistra.fr/fseel/projet-master-23-24/sftp_updater sftp/
docker run -v <full_path>/upload:/upload -d registry.app.unistra.fr/fseel/projet-master-23-24/sftp_updater
```

