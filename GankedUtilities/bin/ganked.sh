#!/usr/bin/env bash
# (c) 2015 Ganked <feedback@ganked.net>

ROOT_PATH="/var/www"
COMMAND_STACK=()

function gnkd_absolute_path() {
    cd $(dirname $0)/$1
    echo $PWD
}

function gnkd_stack_add() {
    COMMAND_STACK+=("$1")
}

function gnkd_stack_run() {
    if [ ${#COMMAND_STACK[@]} -gt 0 ]; then
        vagrant_ssh "$(IFS=";" ; echo "${COMMAND_STACK[*]};")"

        COMMAND_STACK=()
    fi
}

function vagrant_ssh() {
    local private_key_file=$(find "$VAGRANT_CWD" -name "private_key")
    local ip_address=$("$VAGRANT_CWD/bin/ip")

    ssh "vagrant@$ip_address" -i "$private_key_file" ${@}
}

function gnkd_backend_controller() {
    gnkd_stack_add "$ROOT_PATH/GankedBackend/controller.php $1 --dataVersion=\$(redis-cli get currentDataVersion)"
}

function gnkd_in_array_or_empty() {
    if [[ " $1 " =~ " $2 " ]]; then
        return 0
    fi

    if [ ! "$1" ]; then
        return 0
    fi

    return 1
}

export VAGRANT_CWD=$(gnkd_absolute_path ../../GankedBox)


case $1 in
    'help' | '' )
        echo "(c) $(date +"%Y") Ganked. All Rights Reserved."
        printf "\nUsage: gnkd [command] [...args]\n"
        printf "\nCommands:\n"

        echo "help                                        show this message"
        echo "build        [cdn static lolfree champion]  build specific resources"
        echo "git          [...args]                      runs a git command for all repos"
        echo "box          [...args]                      alias for vagrant [..args]"
        echo "task         [taskname]                     call a backend task"
        echo "persist-all                                 persists all redis keys"
        echo "clear-cache                                 clears all cache_* keys"
        echo "pull-cdn                                    runs git pull and ant on the cdn"

        ;;

    'build' )
        builds=${@:2}

        if gnkd_in_array_or_empty "$builds" "static"; then
            gnkd_backend_controller "BuildStaticPage"
        fi

        if gnkd_in_array_or_empty "$builds" "lolfree"; then
            gnkd_backend_controller "LeagueOfLegendsFreeChampionsPush"
        fi

        if gnkd_in_array_or_empty "$builds" "champion"; then
            gnkd_backend_controller "BuildChampionPages"
        fi

        if gnkd_in_array_or_empty "$builds" "cdn"; then
            gnkd_stack_add "cd $ROOT_PATH/GankedAssets && make"
        fi

        ;;

    'task' )
        TASK="${@:2}"
        tput setaf 4
        echo "Running task '$TASK'"
        tput sgr0
        gnkd_backend_controller "$TASK"
        ;;

    'git' )
        GANKED_PATH=$(gnkd_absolute_path "../../")

        for REPO in $(ls $GANKED_PATH); do
            REPO_PATH="$GANKED_PATH/$REPO"

            if [[ -d "$REPO_PATH" ]]; then
                printf "\033[0;36m=> $REPO\033[0m\n"
                cd $REPO_PATH

                git ${@:2}
            fi
        done

        ;;

    'box' )
        if [ "$2" = "ssh" ]
        then
            vagrant_ssh
        else
            vagrant ${@:2}
        fi
        ;;

    'persist-all' )
        gnkd_stack_add "gnkd-persist-all"
        ;;

    'clear-cache' )
        gnkd_stack_add "gnkd-clear-cache"
        ;;

    'pull-cdn' )
        ssh rammus "cd /var/www/GankedAssets-new && git fetch && git reset --hard origin/master && ant"
        ;;

    * )
        echo "Invalid command '$1'. Type 'ganked help' for more info."
        ;;
esac

gnkd_stack_run
