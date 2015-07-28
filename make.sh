#!/bin/bash
cp -Rf ./design/themes/responsive ./design/themes/basic
tar --exclude "./.git" --exclude "./.idea" --exclude "./rees46.tgz" --exclude "./.gitignore" --exclude "./README.md" --exclude "./create_symlink.php" --exclude "./make.sh" -cvzf rees46.tgz ./
rm -Rf ./design/themes/basic
