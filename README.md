![Build status](http://vps2.gridwaves.com:8111/app/rest/builds/buildType:(id:FrameworkScaffold_DevelopmentBuild)/statusIcon)

# Framework Scaffold

This is a minimal project configuration for scaffolding.

## Before you start

Make sure to run in git-bash **as ADMINISTRATOR**.

## Initial setup (for the lazy)

```
git clone https://github.com/kburnik/framework-scaffold && \
cd framework-scaffold &&\
./dev-setup.sh
```

## Initial setup step by step:

```
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

```

## Notes

This project is bulit on a TeamCity Continouous intergration server.

