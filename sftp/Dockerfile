FROM ubuntu:20.04

COPY requirements.txt requirements.txt
COPY start.sh start.sh
COPY insert.py insert.py

RUN apt-get update && apt install -y python3 pip
RUN pip install -r requirements.txt

RUN mkdir data

CMD ["sh", "start.sh"]