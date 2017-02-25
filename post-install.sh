#/bin/bash

set -e

find ./vendor -name ".git" -exec rm -rf {} \;
find ./vendor -name ".gitignore" -exec rm {} \;
find ./vendor -name "*.md" -exec rm -rf {} \;

echo "Removing Useless Files"