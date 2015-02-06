#!/bin/bash
cp -Rf ./design/themes/basic ./design/themes/responsive
tar --exclude "./.git" --exclude "./.idea" --exclude "./rees46.tgz" --exclude "./.gitignore" --exclude "./README.md" --exclude "./create_symlink.php" --exclude "./make.sh" -cvzf rees46.tgz ./
rm -Rf ./design/themes/responsive
