#!/bin/bash

# environment setup
CWD=$(pwd)
DESTDIR=${DESTDIR:-$CWD/src}
TMP=${TMP:-$CWD/tmp}

if ! [ -e "$TMP" ]; then
  mkdir "$TMP"
fi

# interactions download locations
PSRLOG="https://github.com/php-fig/log/archive/1.0.2.tar.gz"
RESQUE="https://github.com/chrisboulton/php-resque/archive/981ef3da53f671c14f8fc61a233c3974f04128a9.tar.gz"
APNSPHP="https://github.com/M2Mobi/ApnsPHP/archive/2f5965c37568a26084d7544947cc0883ad2dac0d.tar.gz"
PHPMAILER="https://github.com/PHPMailer/PHPMailer/archive/v6.0.0rc4.tar.gz"
REQUESTS="https://github.com/rmccue/Requests/archive/v1.7.0.tar.gz"

if ! [ -e "$DESTDIR/Psr/Log" ]; then
  cd "$TMP"
    wget --content-disposition "$PSRLOG"
    tar xvf log-1.0.2.tar.gz

    mv log-1.0.2/Psr "$DESTDIR/"
  cd -
fi

if ! [ -e "$DESTDIR/Resque" ]; then
  cd "$TMP"
    wget --content-disposition "$RESQUE"
    tar xvf php-resque-981ef3da53f671c14f8fc61a233c3974f04128a9.tar.gz

    mv php-resque-981ef3da53f671c14f8fc61a233c3974f04128a9/lib "$DESTDIR/Resque"
  cd -
fi

# remove old version of ApnsPHP
if [ -f "$DESTDIR/ApnsPHP/Log/Interface.php" ]; then
  rm -rf "$DESTDIR/ApnsPHP"
fi

if ! [ -e "$DESTDIR/ApnsPHP" ]; then
  cd "$TMP"
    wget --content-disposition "$APNSPHP"
    tar xvf ApnsPHP-2f5965c37568a26084d7544947cc0883ad2dac0d.tar.gz

    mv ApnsPHP-2f5965c37568a26084d7544947cc0883ad2dac0d/ApnsPHP "$DESTDIR/ApnsPHP"
  cd -
fi

if ! [ -e "$DESTDIR/PHPMailer" ]; then
  cd "$TMP"
    wget --content-disposition "$PHPMAILER"
    tar xvf PHPMailer-6.0.0rc4.tar.gz

    mkdir -p "$DESTDIR/PHPMailer"
    mv PHPMailer-6.0.0rc4/src "$DESTDIR/PHPMailer/PHPMailer"
  cd -
fi

if ! [ -e "$DESTDIR/Requests" ]; then
  cd "$TMP"
    wget --content-disposition "$REQUESTS"
    tar xvf Requests-1.7.0.tar.gz

    mv Requests-1.7.0/library "$DESTDIR/Requests"
  cd -
fi

# cleanup
rm -rf "$TMP"/*

echo "All interactions setup!"
