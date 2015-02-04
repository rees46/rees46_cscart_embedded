#!/bin/bash
cp ./design/themes/basic ./design/themes/responsive
tar --exclude "./.git" --exclude "./.idea" --exclude "./rees46.tgz" --exclude "./.gitignore" --exclude "./README.md" -cvzf rees46.tgz ./
rm -Rf ./design/themes/responsive
