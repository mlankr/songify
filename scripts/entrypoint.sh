#!/bin/bash

set -e
service ssh start

# Start the Apache web server
apache2-foreground