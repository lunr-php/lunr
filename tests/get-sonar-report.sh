#!/bin/bash

SONAR_TMP=$(mktemp -d -t sonar-XXXXXXXXXX)
PROJECT="$1"

PAGE=1
FETCHED=0

while [ "$FETCHED" = 0 ]; do
curl -s -u $SONAR_AUTH_TOKEN: $SONAR_HOST_URL/api/issues/search?componentKeys=$PROJECT\&p=$PAGE > $SONAR_TMP/sonar-p$PAGE.json

SONAR_P=$(jq '.p' $SONAR_TMP/sonar-p$PAGE.json)
SONAR_PS=$(jq '.ps' $SONAR_TMP/sonar-p$PAGE.json)
SONAR_TOTAL=$(jq '.total' $SONAR_TMP/sonar-p$PAGE.json)

if [ $(($SONAR_P * $SONAR_PS)) -ge $SONAR_TOTAL ]; then
  FETCHED=1
else
  PAGE=$(($PAGE + 1))
fi
done

jq -rs 'reduce .[] as $item ({}; .issues |= . + $item.issues)' $SONAR_TMP/sonar-p*.json > $SONAR_TMP/merged_issues.json
jq '.issues = input.issues' $SONAR_TMP/sonar-p1.json $SONAR_TMP/merged_issues.json | jq -f tests/sonar-report.jq > build/logs/sonar-report.json

rm -rf $SONAR_TMP
