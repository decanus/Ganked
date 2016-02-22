#!/usr/bin/env bash

source "$(dirname $0)/helpers/file.sh"

#
# @param $1 input
# @param $2 image_width
# @param $3 border_width
# @param $4 output_dir
#
function remove_border() {
    local new_width=$(bc <<< "$2 - 2 * $3")
    local output=$(get_abs_filename "$4/$(basename $1)")
    local size="$(echo $new_width)x$(echo $new_width)+$3+$3"

    convert "$1" -crop $size $output
    optipng $output
}

#
# @param $1 input_dir
# @param $2 image_width
# @param $3 border_width
#
function handle_raw() {
    local files=$(ls $(get_abs_filename "images/raw/$1"))

    for file in $files
    do
        remove_border "images/raw/$1/$file" $2 $3 "images/$1"
    done
}

handle_raw "lol/item" 62 2
handle_raw "lol/champion/icon" 120 8