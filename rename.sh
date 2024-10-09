#!/bin/bash

# Set the directory path
DIR="/path/to/your/files"

# Navigate to the directory
cd "$DIR" || exit

# List files in the directory sorted by modification time (newest to oldest)
# and store them in an array
files=($(ls -t *.png))

# Loop through the array and rename files
for ((i=0; i<${#files[@]}-1; i++)); do
  mv "${files[$i]}" "${files[$((i+1))]}"
done

# Remove the oldest file (last in the array)
rm "${files[-1]}"

echo "Renaming complete and last file deleted."
