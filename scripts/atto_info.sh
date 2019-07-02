#!/bin/bash
# set -e
# set -u
# set -o pipefail

# Skip manual check
if [ "$1" = 'manualcheck' ]; then
	echo 'Manual check: skipping'
	exit 0
fi

# Create cache dir if it does not exist
DIR=$(dirname "$0")
mkdir -p "$DIR/cache"
atto_file="$DIR/cache/atto_info.txt"

atto_atfcinfo_binary="/Applications/ATTO/ThunderLinkFC16/atfcinfo"
atto_atinfo_binary="/Applications/ATTO/ThunderLinkFC16/atinfo"
atto_atflash_binary="/Applications/ATTO/ThunderLinkFC16/atflash"

IFS=$'\n'
channels=(Channel\ 1 Channel\ 2)

if [[ -f "${atto_atfcinfo_binary}" && -f "${atto_atinfo_binary}" && -f "${atto_atflash_binary}" ]]
then
    echo "" > "${atto_file}"
    for channel in ${channels[@]}
    do
        channel_data=$("$atto_atfcinfo_binary" -i all | grep -A 31 "$channel")
        driver_data=$("$atto_atinfo_binary" -i all | grep -A 21 "$channel")
        
        echo "Channel: $channel" >> "${atto_file}"
        
        echo -n "Model: " >> "${atto_file}"
        echo $("$atto_atfcinfo_binary" -i all | grep -A 31 "$channel" | awk -F: '/^Channel/ { print $2}' | awk '{$1=$1;print}') >> "${atto_file}"
        
        echo -n "Port State: " >> "${atto_file}"
        echo $("$atto_atfcinfo_binary" -i all | grep -A 31 "$channel" | awk -F: '/^Port State:/ {print $2}' | awk '{$1=$1;print}') >> "${atto_file}"
        
        echo -n "Port Address: " >> "${atto_file}"
        echo $("$atto_atfcinfo_binary" -i all | grep -A 31 "$channel" | awk '/^Port Address:/ { print $3 }') >> "${atto_file}"
        
        echo -n "Driver Version: " >> "${atto_file}"
        echo $("$atto_atinfo_binary" -i all | grep -A 21 "$channel" | awk -F: '/^Driver Version:/ { print $2 }' | awk '{$1=$1;print}') >> "${atto_file}"
    
        echo -n "Firmware Version: " >> "${atto_file}"
        echo $("$atto_atinfo_binary" -i all | grep -A 21 "$channel" | awk -F: '/^Firmware Version:/ { print $2 }' | awk '{$1=$1;print}') >> "${atto_file}"
        
        echo -n "Flash Version: " >> "${atto_file}"
        echo $("$atto_atinfo_binary" -i all | grep -A 21 "$channel" | awk -F: '/^Flash Version:/ { print $2 }' | awk '{$1=$1;print}') >> "${atto_file}"
        
        echo "----------" >> "${atto_file}"
    done

fi
