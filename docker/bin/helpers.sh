#!/usr/bin/env bash

function compose {
    local cmd="docker-compose -p importing-tool"
    ${cmd} "$@"
}