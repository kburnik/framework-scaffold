#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR

destination_dir="$DIR/third_party/composer"
[ ! -d "$destination_dir" ] && mkdir -p "$destination_dir"

cd $destination_dir && composer require mikehaertl/phpwkhtmltopdf
