#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR

[ ! -d "third_party" ] && mkdir third_party
remote=https://github.com/kburnik/framework-toolbox.git
branch=master
repo=toolbox

cd $DIR/third_party

if [ -d "$repo" ]; then
  cd $repo && git pull origin $branch
else
  git clone -b $branch $remote $repo
fi

