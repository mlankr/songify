#!/bin/bash

# Load environment variables from .env.azure file
source .env.azure

# Check if required environment variables are set
if [ -z "$ACR_REGISTRY" ] || [ -z "$IMAGE_WEB" ]; then
  echo "Error: Required environment variables not set. Please check your .env file."
  exit 1
fi

# Login to ACR
az acr login --name "$ACR_NAME"

# Tag the local Docker image with ACR repository information
docker tag "$IMAGE_WEB" "$ACR_REGISTRY/$IMAGE_WEB"

# Push the image to ACR
docker push "$ACR_REGISTRY/$IMAGE_WEB"

# Logout from ACR
docker logout "$ACR_REGISTRY"

echo "Image pushed to Azure Container Registry ✔"
