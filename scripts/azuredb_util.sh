#!/bin/bash

# Check for the argument (path to .env.mysql file)
if [ $# -ne 2 ]; then
  echo "Error: Please provide the path to the .env.mysql file  with DB credentials as the first argument and the task (export/import) as the second argument. X"
  exit 1
fi

# Check if the provided .env.mysql file exists
if [ ! -f "$1" ]; then
  echo "Error: The specified .env file does not exist! X"
  exit 1
fi

# Load environment variables from the provided .env.mysql file
# shellcheck disable=SC1090
source "$1"

# Function to export the database
export_database() {
  echo "Exporting the database..."

  # database export command, password through STDIN
  mysqldump -h "$DB_HOST" -u "$DB_USERNAME" -p "$DB_NAME" > ./db/export.sql
}

# Function to import the database
import_database() {
  echo "Importing the database..."

  # database import command, password through STDIN
  mysql -h "$DB_HOST" -u "$DB_USERNAME" -p "$DB_NAME" < ./db/seedDB/songify.sql
}

# Check for the argument
if [ $# -eq 1 ]; then
  echo "Error: Please provide an argument (export/import). X"
  exit 1
fi

# Perform action based on the argument
case $2 in
"export")
  export_database
  ;;
"import")
  import_database
  ;;
*)
  echo "Error: Invalid argument. Please use 'export' or 'import'! X"
  exit 1
  ;;
esac

echo "Done ✔"
