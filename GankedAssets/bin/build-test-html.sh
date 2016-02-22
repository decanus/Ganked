#!/usr/bin/env bash

SCRIPTS=""

for TEST in $@
do
    SCRIPTS=$(printf '%s<script src="%s"></script>' "$SCRIPTS" ${TEST/test\//})
done

OUT=$(cat | sed -e "s#--sources--#$SCRIPTS#g")

echo "$OUT"