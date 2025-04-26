#!/bin/bash
IS_LOCAL=true
export GOROOT=/usr/local/go
export SERVICE=api
export TMPPATH=/go/tmp

if [[ "$1" == 'gomod' ]]; then
	gitCloneSetup
	cd /go/src/auth
	echo "Executing go mod ${*:2}"
	go mod ${*:2}
fi

if [[ "$1" == 'bash' ]]; then
	echo "Build bash command"
	/bin/sh -c bash
fi


if [[ "$1" == 'run' ]]; then
	echo "Executing job: $2"
	./api -j $2
fi

if [[ "$1" == 'bee' ]]; then
	cd /go/src/api && /go/src/api/bin/bee ${*:2}
fi

if [[ -z "$1" ]]; then
	appPath="src/api"

	cd ${appPath}

	if $IS_LOCAL; then
		go mod vendor -v
		export GOFLAGS=-mod=vendor
		/go/bin/bee run -e pkg
	else
		./api
	fi
fi
