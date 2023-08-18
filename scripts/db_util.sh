#!/bin/bash

# Load environment variables from .env.mysql
source .env.mysql

# Function to export the database
export_database() {
  echo "Exporting the database..."

  # database export command, password through STDIN
  mysqldump -h $DB_HOST -u $DB_USER -p $DB_PASSWORD $DB_NAME > ./db/export.sql
}

# Function to import the database
import_database() {
  echo "Importing the database..."

  # database import command, password through STDIN
  mysql -h $DB_HOST -u $DB_USER -p $DB_PASSWORD $DB_NAME < ./db/seedDB/songify.sql
}

# Check for the argument
if [ $# -eq 0 ]; then
  echo "Error: Please provide an argument (export/import). X"
  exit 1
fi

# Perform action based on the argument
case $1 in
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
