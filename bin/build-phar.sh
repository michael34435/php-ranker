#!/usr/bash

dir=$(pwd)/../
rm -rf ${dir}/build/php-ranker
curl -LOk https://github.com/clue/phar-composer/releases/download/v1.0.0/phar-composer.phar
php phar-composer.phar build ${dir}
chmod +x php-ranker.phar
mv php-ranker.phar ${dir}/build/php-ranker
rm -rf phar-composer.phar
