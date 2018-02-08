#!/bin/bash

hash_file="/tmp/nodejshash"

check_if_npm_packages_has_to_be_installed () {
    if [ -f $hash_file ]; then
        check_if_same_hash
    else
        return 0
    fi
}

check_if_same_hash () {
    hash_new="$(md5sum .ebextensions/bin/install-nodejs.sh 2> /dev/null | cut -d ' ' -f 1)"
    hash_current="$(cat "$hash_file" 2> /dev/null | cut -d ' ' -f 1)"

    if [ $hash_new == $hash_current ]; then
        return 1
    else
        return 0
    fi
}

install_node () {
    if hash nodejs 2> /dev/null; then
        echo 'nodejs install, add more processing if needed' > /dev/null
    else
        curl --silent --location https://rpm.nodesource.com/setup_8.x | sudo bash -
        sudo yum -y install nodejs
    fi
}


update_current_hash () {
    echo $hash_new > $hash_file
}

install_node

if check_if_npm_packages_has_to_be_installed; then
    update_current_hash
fi