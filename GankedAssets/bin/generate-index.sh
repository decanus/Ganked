#!/usr/bin/env bash

counter=0

scan-directory() {
    local items=$(ls $1)
    local index="$1/all.scss"

    if ! grep -q "build: ignore" $index
    then
        rm $index
        touch $index

        for item in $items; do
            if [ -d "$1/$item" ]; then
                echo "@import '$item/all';" >> $index
                scan-directory "$1/$item"
            else
                local name=$(basename $(echo "$item" | cut -d "_" -f 2) .scss)

                if [ $name != "all" ]; then
                    echo "@import '$name';" >> $index
                    counter=$(($counter + 1))
                fi
            fi
        done
    fi
}

for item in $(ls $1); do
    if [ -d "$1/$item" ]; then
        scan-directory "$1/$item"
    fi
done

echo "Indexed $counter files."