#!/bin/bash

# atto_info controller
CTL="${BASEURL}index.php?/module/atto_info/"

# Get the scripts in the proper directories
"${CURL[@]}" "${CTL}get_script/atto_info.sh" -o "${MUNKIPATH}preflight.d/atto_info.sh"

# Check exit status of curl
if [ $? = 0 ]; then
	# Make executable
	chmod a+x "${MUNKIPATH}preflight.d/atto_info.sh"

	# Set preference to include this file in the preflight check
	setreportpref "atto_info" "${CACHEPATH}atto_info.txt"

else
	echo "Failed to download all required components!"
	rm -f "${MUNKIPATH}preflight.d/atto_info.sh"

	# Signal that we had an error
	ERR=1
fi

