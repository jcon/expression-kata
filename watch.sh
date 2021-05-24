#!/bin/bash

OS=$(uname)

if [[ $OS =~ Darwin ]]; then
	which fswatch 2>&1 > /dev/null
	if [[ $? != 0 ]]; then
		echo "ERROR: fswatch missing. Install it first:

brew install fswatch"
		exit 1
	fi
	fswatch -o ./src ./tests | xargs -n1 -I{} ./test.sh
else
	while inotifywait -e close_write ./src ./tests; do ./test.sh; done
fi
