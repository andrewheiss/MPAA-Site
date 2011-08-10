desc "Deploy to live server"
task :deploy do
  rsync "mpaa:/home/mpaa/www/sites/default/themes/mpaa"
end

def rsync(location)
  sh "rsync -rtvz --exclude-from '.rsync' --delete --stats --progress . #{location}"
end