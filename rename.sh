#!/bin/bash

# Navigate to the Downloads directory
cd /path/to/captchas || exit

# Get a list of .png files sorted by modification time (newest first)
png_files=($(ls -t *.png))

# Check if there are enough files to rename
if [ ${#png_files[@]} -lt 2 ]; then
  echo "Not enough .png files to perform the operation."
  exit 1
fi

# Temporary file names to avoid overwriting
for ((i=0; i<${#png_files[@]}; i++)); do
  mv "${png_files[$i]}" "${png_files[$i]}.tmp"
done

# Rebuild the array with the temporary names
png_files=($(ls -t *.tmp))

# Rename all .png.tmp files from newest to oldest, except the newest
for ((i=${#png_files[@]}-1; i>0; i--)); do
  base_name="${png_files[$((i-1))]%.png.tmp}"  # Remove both .png.tmp extensions
  mv "${png_files[$i]}" "${base_name}.png"
done

# Rename the second newest file to toDelete.png
mv "${png_files[1]}" "toDelete.png"

# Delete the newest file
rm "${png_files[0]}"

echo "Operation completed."