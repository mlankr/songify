#!/bin/bash

# Check if the SCSS file exists
if [ ! -f "./src/public/assets/scss/style.scss" ]; then
  echo "Error: SCSS file './src/public/assets/scss/style.scss' not found!"
  exit 1
fi

# Run the Sass watch command
sass ./src/public/assets/scss/style.scss:./src/public/assets/css/style.css --watch
