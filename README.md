# gendiff

<a href="https://github.com/molych/php-project-lvl2/actions"><img src="https://github.com/molych/php-project-lvl2/workflows/PHP-CI/badge.svg" /></a>
<a href="https://codeclimate.com/github/molych/php-project-lvl2/maintainability"><img src="https://api.codeclimate.com/v1/badges/9f01e7c6942d28ea6234/maintainability" /></a>
<a href="https://codeclimate.com/github/molych/php-project-lvl2/test_coverage"><img src="https://api.codeclimate.com/v1/badges/9f01e7c6942d28ea6234/test_coverage" /></a><br>


Program compares two configuration files. The file comparison result can be displayed in different formats: for example, plain ("flat") or json ("JSON format")
```
Generate diff

Usage:
  gendiff (-h|--help)
  gendiff (-v|--version)
  gendiff [--format <fmt>] <firstFile> <secondFile>
  
Options:
  -h --help                     Show this screen
  -v --version                  Show version
  --format <fmt>                Report format [default: stylish]
  ```

### install

```
composer global require
```


Comparison of flat files (JSON)

<a href="https://asciinema.org/a/363626"><img src="https://asciinema.org/a/363626.png" width="320"/></a>
