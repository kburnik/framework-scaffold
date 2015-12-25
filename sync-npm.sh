#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR

# This will output to node_modules.
destination_dir="$DIR/public_html/third_party"
[ ! -d "$destination_dir" ] && mkdir -p "$destination_dir"

cd $destination_dir && \
  npm install \
    angular-ui-bootstrap \
    jquery.browser \
    angular-file-upload
