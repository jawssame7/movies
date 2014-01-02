dir = File.expand_path(File.dirname(__FILE__))

# Project root path
project_path = File.join(dir, "..")

# Load the modular-scale
require 'modular-scale'

# Compass configurations
sass_path = dir
css_dir = File.join("css")
images_dir = File.join("img")
fonts_path = File.join("fonts")
relative_assets = true

# Require any additional compass plugins here.
environment = :development
output_style = (environment == :production) ? :compressed : :expanded

# Load the sass-bootstrap
add_import_path(File.join(dir, "..", "bower_components", "gumby", "sass"))
