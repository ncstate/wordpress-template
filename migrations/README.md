# How to use NC State Theme migrations

## Overview

The files in this directory are for executing any DB updates required between theme versions.

For example, this theme uses an option variable in the wp_options table called `ncstate_theme_version`.
If for some reason a future theme version requires the option to be renamed as `ncstate_theme_id`, 
I can use this directory to do so.

## How To

The following steps will guide you through creating a migration:

1. Create a .php file in `/migrations` with the version number as the file name.
  - If the current template version is 1.0.4 and I need to make DB updates with 1.1.0,
  I simply create 1.1.0.php in the `/migrations` directory.
2. Write the migration functions in your new file. Be sure to call them as well so that
   they are executed.
3. Make sure the version number gets updated in style.scss.

When the new version of the template loads, it will see that you have upgraded and
execute all necessary migrations. Once a migration has been run once, it will not be run
again.
