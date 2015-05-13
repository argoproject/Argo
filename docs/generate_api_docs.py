#!/usr/bin/python

# This searches the Largo project for PHP files, excluding those third-party
# source files in /lib, /js, and /node_modules, and runs the command
# `doxphp < input.php | doxphp2sphinx > output.rst` to extract PHPDocs to
# RST file format suitable for use with Sphinx and ReadTheDocs.
from __future__ import print_function
import os

# Since this script lives in the /docs folder, we need to search from ../
for dirpath, dirnames, filenames in os.walk('../'):
    # We don't care about PHP files found in 3rd-party library folders
    if '../lib' in dirpath or '../js' in dirpath or '../node_modules' in dirpath:
        continue
    for filename in filenames:
        if os.path.splitext(filename)[-1] == '.php':
            src = os.path.join(dirpath, filename)
            # A file with src path ../404.php should output to api/404.rst
            dest = src.replace('..', 'api').replace('.php', '.rst')
            command = 'doxphp < {src} | doxphp2sphinx > {dest}'.format(src=src, dest=dest)
            print(command)
            os.system(command)
