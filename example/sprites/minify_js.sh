#!/bin/bash

python ../../compress_js.py ./js/game.js warnings
python ../../compress_js.py ./js/common.js warnings
python ../../compress_js.py ./js/sprite.js warnings
python ../../compress_js.py ./js/sprite_data.js warnings
python ../../compress_js.py ./js/spritemanager.js warnings

python ../../compress_js.py ./js/game.js errors
python ../../compress_js.py ./js/common.js errors
python ../../compress_js.py ./js/sprite.js errors
python ../../compress_js.py ./js/sprite_data.js errors
python ../../compress_js.py ./js/spritemanager.js errors

python ../../compress_js.py ./js/game.js compiled_code > ./js/min/game.min.js
python ../../compress_js.py ./js/common.js compiled_code > ./js/min/common.min.js
python ../../compress_js.py ./js/sprite.js compiled_code > ./js/min/sprite.min.js
python ../../compress_js.py ./js/sprite_data.js compiled_code > ./js/min/sprite_data.min.js
python ../../compress_js.py ./js/spritemanager.js compiled_code > ./js/min/spritemanager.min.js
