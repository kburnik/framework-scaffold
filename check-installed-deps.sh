#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR

function check_binary_exists {
  for x in $@; do
    which $x > /dev/null
    if [ "$?" != "0" ]; then
      echo "Missing binary $x" && exit 1
    fi
    echo "$x is installed."
  done;
}

check_binary_exists composer npm wkhtmltopdf lessc
