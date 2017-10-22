#!/bin/bash
uglifyjs -c -m < ./js/lazy.js > ./js/lazy.min.js
uglifyjs -c -m < ./js/sigal.js > ./js/sigal.min.js
php build.php
