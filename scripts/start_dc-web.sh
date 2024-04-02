# Check for the argument (Docker Compose file name)
if [ $# -ne 1 ]; then
  echo "Error: Please provide the Docker Compose file name as an argument."
  exit 1
fi

# Check if the provided Docker Compose file exists
if [ ! -f "$1" ]; then
  echo "Error: The specified Docker Compose file does not exist."
  exit 1
fi

# Determine if docker-compose.azure is being run
if [[ "$1" == "docker-compose.web.yml" ]]; then
  # Use .env.azure as the environment file
  env_file=".env.web"
else
  # Use default .env as the environment file
  env_file=".env"
fi

# Run Docker Compose with the specified file and environment file
docker-compose --env-file "$env_file" -f "$1" up -d --build

echo "Docker Compose started successfully!"