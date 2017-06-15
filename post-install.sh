#!/usr/bin/env bash
#/bin/bash

find ./vendor -name ".git" -exec rm -rf {} \; 2>/dev/null
find ./vendor -name ".gitignore" -exec rm {} \; 2>/dev/null
find ./vendor -name "*.md" -exec rm -rf {} \; 2>/dev/null
find ./vendor -name "*LICENSE.txt" -exec rm -rf {} \; 2>/dev/null
find ./vendor -name "LICENSE" -exec rm -rf {} \; 2>/dev/null
find ./vendor -name "*.yml" -exec rm -rf {} \; 2>/dev/null
find ./vendor -name "docs/*" -exec rm -rf {} \; 2>/dev/null
find ./vendor -name "tests/*" -exec rm -rf {} \; 2>/dev/null
find ./vendor -name "test/*" -exec rm -rf {} \; 2>/dev/null

echo "Removing Useless Files"