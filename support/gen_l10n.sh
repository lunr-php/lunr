#!/bin/sh

CWD=$(pwd)
DESTDIR=${DESTDIR:-tests/statics/l10n}

for i in "$DESTDIR"/*; do
  if [ -d "$i" ]; then
    if [ -e "$i/LC_MESSAGES/Lunr.po" ]; then
      echo "Generating translation file for $i:"
      msgfmt -v "$i/LC_MESSAGES/Lunr.po" -o "$i/LC_MESSAGES/Lunr.mo"
    fi
  fi
done
