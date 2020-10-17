rm -rf dist/
git stash
git clean -df
git pull origin master
ng build --prod
cp -r dist/pk-form/* ~/public_html/