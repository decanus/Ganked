#!/usr/bin/env bash

source "$(dirname $0)/helpers/file.sh"

function optimize_images {
    DIR="$(get_abs_filename $1)"
    IMAGES=$(find "$DIR" -type f -name "*.$2" -not -iwholename ".git*" -not -iwholename "bower_components*")

    for IMAGE in $IMAGES; do
        $3 $IMAGE
    done
}

if [ -z "$1" ]
then
    echo "Usage: $0 [dir]"
else
    optimize_images "$1" "jpg" "/usr/local/bin/jpegoptim --strip-all"
    optimize_images "$1" "png" "optipng"
    optimize_images "$1" "svg" "svgo"
fi