# Framework-empty-project

This is a minimal project configuration for scaffolding.

## Initial setup:

```
./sync-toolbox.sh

./third_party/toolbox/sync.sh

./sync-npm.sh

# Optional:
./sync-composer.sh

# Start the environment.
. ./third_party/toolbox/env.sh

# Adjust config in project-settings.php

# Create the virtual host and DNS entry.
install-win-xampp.sh

# Init the database.
./initdb.php

# Create initial migration.
migrate.sh

# Register a user.
./model/user/register.php

```

