#!/bin/bash

rm -rf dist
python3 setup.py sdist
nom_du_fichier=$(ls dist/)
sudo pip install dist/$nom_du_fichier -r requirements.txt