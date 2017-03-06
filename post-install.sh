#/bin/bash

find ./vendor -name ".git" -exec rm -rf {} \; 2>/dev/null
find ./vendor -name ".gitignore" -exec rm {} \; 2>/dev/null
find ./vendor -name "*.md" -exec rm -rf {} \; 2>/dev/null

echo "Removing Useless Files"