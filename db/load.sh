#!/bin/sh

BASE_DIR=$(dirname "$(readlink -f "$0")")
if [ "$1" != "test" ]; then
    psql -h localhost -U myplaylist -d myplaylist < $BASE_DIR/myplaylist.sql
fi
psql -h localhost -U myplaylist -d myplaylist_test < $BASE_DIR/myplaylist.sql
