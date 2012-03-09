#!/bin/sh

if [ "$(basename $(pwd))" = "l10n" ]; then
  dir="."
else
  dir="l10n"
fi

for i in $dir/*; do
  if [ -d "$i" ]; then
    if [ -e "$i/LC_MESSAGES/Lunr.po" ]; then
      echo "Generating translation file for $i:"
      msgfmt -v "$i/LC_MESSAGES/Lunr.po" -o "$i/LC_MESSAGES/Lunr.mo"
    fi
  fi
done
