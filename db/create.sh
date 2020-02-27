#!/bin/sh

if [ "$1" = "travis" ]; then
    psql -U postgres -c "CREATE DATABASE myplaylist_test;"
    psql -U postgres -c "CREATE USER myplaylist PASSWORD 'myplaylist' SUPERUSER;"
else
    sudo -u postgres dropdb --if-exists myplaylist
    sudo -u postgres dropdb --if-exists myplaylist_test
    sudo -u postgres dropuser --if-exists myplaylist
    sudo -u postgres psql -c "CREATE USER myplaylist PASSWORD 'myplaylist' SUPERUSER;"
    sudo -u postgres createdb -O myplaylist myplaylist
    sudo -u postgres psql -d myplaylist -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    sudo -u postgres createdb -O myplaylist myplaylist_test
    sudo -u postgres psql -d myplaylist_test -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    LINE="localhost:5432:*:myplaylist:myplaylist"
    FILE=~/.pgpass
    if [ ! -f $FILE ]; then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE; then
        echo "$LINE" >> $FILE
    fi
fi
