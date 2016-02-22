#!/usr/bin/env bash

repos=('GankedAssets' 'GankedBackend' 'GankedFetchFramework' 'GankedFrontend' 'GankedLibrary' 'GankedPost' 'GankedServices' 'GankedSkeleton' 'GankedTemplates' 'GankedApi' 'GankedBox')

if [ ${PWD##*/} != "Ganked" ]; then

echo "Someone fucked up"
exit 1

fi

for var in "${repos[@]}"
do

pwd
    cd ${var}

    test=$(git rev-parse --abbrev-ref HEAD)

    git checkout development && git pull && git checkout $test

    cd ../
done
