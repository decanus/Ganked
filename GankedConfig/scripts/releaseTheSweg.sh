#!/usr/bin/env bash

printf "
                                                                                                        dddddddd
        GGGGGGGGGGGGG                                   kkkkkkkk                                        d::::::d
     GGG::::::::::::G                                   k::::::k                                        d::::::d
   GG:::::::::::::::G                                   k::::::k                                        d::::::d
  G:::::GGGGGGGG::::G                                   k::::::k                                        d:::::d
 G:::::G       GGGGGG  aaaaaaaaaaaaa  nnnn  nnnnnnnn     k:::::k    kkkkkkk eeeeeeeeeeee        ddddddddd:::::d
G:::::G                a::::::::::::a n:::nn::::::::nn   k:::::k   k:::::kee::::::::::::ee    dd::::::::::::::d
G:::::G                aaaaaaaaa:::::an::::::::::::::nn  k:::::k  k:::::ke::::::eeeee:::::ee d::::::::::::::::d
G:::::G    GGGGGGGGGG           a::::ann:::::::::::::::n k:::::k k:::::ke::::::e     e:::::ed:::::::ddddd:::::d
G:::::G    G::::::::G    aaaaaaa:::::a  n:::::nnnn:::::n k::::::k:::::k e:::::::eeeee::::::ed::::::d    d:::::d
G:::::G    GGGGG::::G  aa::::::::::::a  n::::n    n::::n k:::::::::::k  e:::::::::::::::::e d:::::d     d:::::d
G:::::G        G::::G a::::aaaa::::::a  n::::n    n::::n k:::::::::::k  e::::::eeeeeeeeeee  d:::::d     d:::::d
 G:::::G       G::::Ga::::a    a:::::a  n::::n    n::::n k::::::k:::::k e:::::::e           d:::::d     d:::::d
  G:::::GGGGGGGG::::Ga::::a    a:::::a  n::::n    n::::nk::::::k k:::::ke::::::::e          d::::::ddddd::::::dd
   GG:::::::::::::::Ga:::::aaaa::::::a  n::::n    n::::nk::::::k  k:::::ke::::::::eeeeeeee   d:::::::::::::::::d
     GGG::::::GGG:::G a::::::::::aa:::a n::::n    n::::nk::::::k   k:::::kee:::::::::::::e    d:::::::::ddd::::d
        GGGGGG   GGGG  aaaaaaaaaa  aaaa nnnnnn    nnnnnnkkkkkkkk    kkkkkkk eeeeeeeeeeeeee     ddddddddd   ddddd
"

repos=('GankedConfig' 'GankedLibrary' 'GankedSkeleton' 'GankedTemplates' 'GankedApi' 'GankedAssets' 'GankedBackend' 'GankedFetchFramework' 'GankedFrontend' 'GankedPost' 'GankedServices')

result=${PWD##*/}

if [ ${PWD##*/} != "Ganked" ]; then

echo "Someone fucked up"
exit 1

fi

for var in "${repos[@]}"
do

echo 'Releasing' $var

    cd ${var}

    test=$(git rev-parse --abbrev-ref HEAD)

    if [ $var = 'GankedConfig' ]; then
        git pull && git push
    else
        git checkout development && git fetch && git pull
        git checkout master && git fetch && git pull && git merge development --no-edit
        git push
    fi

    if [ -z "$1" ]; then
            echo "No tag"
        else
        git tag $1 && git push --tags
    fi

    git checkout $test

    cd ../
done

