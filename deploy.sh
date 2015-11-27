#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR

./check-installed-deps.sh && \
    ./third_party/toolbox/sync.sh && \
    ./sync-composer.sh && \
    ./sync-npm.sh && \
    ./third_party/toolbox/build.sh && \
    ./third_party/toolbox/migrate.sh
