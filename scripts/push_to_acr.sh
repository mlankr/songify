#!/bin/bash

# Load environment variables from .env.acr file
if [ -f .env.acr ]; then
  export $(cat .env.acr | xargs)
fi

# Check if required environment variables are set
if [ -z "$ACR_NAME" ] || [ -z "$IMAGE_NAME" ] || [ -z "$IMAGE_TAG" ]; then
  echo "Error: Required environment variables not set. Please check your .env file."
  exit 1
fi

# Login to ACR
az acr login --name $ACR_NAME

# Tag the local Docker image with ACR repository information
docker tag $IMAGE_NAME:$IMAGE_TAG $ACR_NAME.azurecr.io/$IMAGE_NAME:$IMAGE_TAG

# Push the image to ACR
docker push $ACR_NAME.azurecr.io/$IMAGE_NAME:$IMAGE_TAG

# Logout from ACR
docker logout $ACR_NAME.azurecr.io

echo "Image pushed to Azure Container Registry: $ACR_NAME.azurecr.io/$IMAGE_NAME:$IMAGE_TAG"
