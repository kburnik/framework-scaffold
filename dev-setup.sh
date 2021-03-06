#!/bin/bash

./sync-toolbox.sh

./third_party/toolbox/sync.sh

./sync-npm.sh


# Optional:
./sync-composer.sh

# Start the environment.
. ./third_party/toolbox/env.sh

# Enable development config
cp project-config.dev.json.ignore project-config.dev.json

# Adjust config in project-config.json and generate
generate-config.php

# Create the virtual host and DNS entry.
install-win-xampp.sh

# Init the database.
./initdb.php

# Create initial migration.
migrate.sh

# Register a user.
./model/user/register.php
