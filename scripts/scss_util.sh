#!/bin/bash

SRC_SASS="src/public/assets/scss/style.scss"
DEST_CSS="src/public/assets/css/style.css"

# Watch for changes in the style.scss file and compile to style.css
sass --watch "$SRC_SASS":"$DEST_CSS"