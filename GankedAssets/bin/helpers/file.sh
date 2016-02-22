#!/usr/bin/env bash

function get_abs_filename {
  # $1 : relative filename
  echo "$(cd "$(dirname "$1")" && pwd)/$(basename "$1")"
}

function get_file_basename {
	FILENAME="$(basename $1)"
	echo ${FILENAME%.*}
}