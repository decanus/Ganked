#!/usr/bin/env bash

repos=('GankedApi' 'GankedSearchFramework' 'GankedAssets' 'GankedBackend' 'GankedBox' 'GankedFetchFramework' 'GankedFrontend' 'GankedLibrary' 'GankedPost' 'GankedServices' 'GankedSkeleton' 'GankedSockets' 'GankedTemplates')

git clone git@github.com:decanus/GankedApi.git
git clone git@github.com:bash/GankedBox.git

for var in "${repos[@]}"
do
    git clone git@github.com:/Ganked/${var}.git && cd ${var}
done

exit 0
