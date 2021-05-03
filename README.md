# Today I Learned
A simple generator tool to generate small snippets (TILs) into a static site.

## Usage

    $ til-generator.phar generate <srcdir> 

You can use a different theme:

    $ til-generator.phar generate <srcdir> --theme <theme> 

Check out which themes are available:

    $ til-generator.phar list-themes


## Compile
    
    $ composer install
    $ ./vendor/bin/box compile

This will generate a phar file which can be used to distribute.

## Bugs

yes.
