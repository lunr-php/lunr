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
RESQUE="https://github.com/chrisboulton/php-resque/archive/cf187fae522df085f79837d3763645da066194d6.tar.gz"
APNSPHP="https://github.com/M2Mobi/ApnsPHP/archive/b9c04fdfdf63da714fbb06e4151d939e0e9fdccb.tar.gz"
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
    tar xvf php-resque-cf187fae522df085f79837d3763645da066194d6.tar.gz

    mv php-resque-cf187fae522df085f79837d3763645da066194d6/lib "$DESTDIR/Resque"
  cd -
fi

# remove old version of ApnsPHP
if [ -f "$DESTDIR/ApnsPHP/Log/Interface.php" ]; then
  rm -rf "$DESTDIR/ApnsPHP"
fi

if ! [ -e "$DESTDIR/ApnsPHP" ]; then
  cd "$TMP"
    wget --content-disposition "$APNSPHP"
    tar xvf ApnsPHP-b9c04fdfdf63da714fbb06e4151d939e0e9fdccb.tar.gz

    mv ApnsPHP-b9c04fdfdf63da714fbb06e4151d939e0e9fdccb/ApnsPHP "$DESTDIR/ApnsPHP"
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
