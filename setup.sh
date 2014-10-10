#!/bin/bash
mkdir -p ./sessions/connections
mkdir -p ./sessions/controller
mkdir -p ./sessions/courts
mkdir -p ./players
chmod a+w -R ./sessions
chmod a+w -R ./players
cp settings.php.template settings.php
