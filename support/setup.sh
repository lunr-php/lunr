#!/bin/bash

# environment setup
CWD=$(pwd)
DESTDIR=${DESTDIR:-$CWD/src}
TMP=${TMP:-$CWD/tmp}

if ! [ -e "$TMP" ]; then
  mkdir "$TMP"
fi

# interactions download locations
PSRLOG="https://github.com/php-fig/log/archive/1.0.0.tar.gz"
RESQUE="https://github.com/chrisboulton/php-resque/archive/1.2.tar.gz"
APNSPHP="https://github.com/immobiliare/ApnsPHP/archive/v1.0.1.tar.gz"

if ! [ -e "$DESTDIR/Psr/Log" ]; then
  cd "$TMP"
    wget --content-disposition "$PSRLOG"
    tar xvf log-1.0.0.tar.gz

    mv log-1.0.0/Psr "$DESTDIR/"
  cd -
fi

if ! [ -e "$DESTDIR/Resque" ]; then
  cd "$TMP"
    wget --content-disposition "$RESQUE"
    tar xvf php-resque-1.2.tar.gz

    mv php-resque-1.2/lib "$DESTDIR/Resque"
  cd -
fi

if ! [ -e "$DESTDIR/ApnsPHP" ]; then
  cd "$TMP"
    wget --content-disposition "$APNSPHP"
    tar xvf ApnsPHP-1.0.1.tar.gz

    mv ApnsPHP-1.0.1/ApnsPHP "$DESTDIR/ApnsPHP"
  cd -
fi

# cleanup
rm -rf "$TMP"/*

echo "All interactions setup!"
