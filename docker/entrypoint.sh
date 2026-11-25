#!/bin/sh
set -eu

if [ "${GNS3_MODE:-false}" = "true" ]; then
    ifup eth0 || true
fi

exec gosu www-data "$@"
