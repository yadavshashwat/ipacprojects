rm -rf dist/
git stash
git clean -df
git pull origin master
git push origin master
ng build --prod
cp -r dist/angular-whatsapp/* ~/public_html/