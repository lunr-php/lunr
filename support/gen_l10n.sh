#!/bin/sh
# SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
# SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
# SPDX-License-Identifier: CC0-1.0

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
