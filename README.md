### Hexlet tests and linter status:
[![Actions Status](https://github.com/kaivladimirv/php-project-48/workflows/hexlet-check/badge.svg)](https://github.com/kaivladimirv/php-project-48/actions)
[![Maintainability](https://api.codeclimate.com/v1/badges/b3f25a564898554531c9/maintainability)](https://codeclimate.com/github/kaivladimirv/php-project-48/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/b3f25a564898554531c9/test_coverage)](https://codeclimate.com/github/kaivladimirv/php-project-48/test_coverage)
[![PHP CI](https://github.com/kaivladimirv/php-project-48/actions/workflows/php-ci.yml/badge.svg)](https://github.com/kaivladimirv/php-project-48/actions/workflows/php-ci.yml)

## Usage

Comparing two flat json files

    ```
    $ ./bin/gendiff file1.json file2.json
    ```
[![asciicast](https://asciinema.org/a/TIl1sUFq00HaJjBML0i0MbfbR.svg)](https://asciinema.org/a/TIl1sUFq00HaJjBML0i0MbfbR)

Comparing two flat yaml files

    ```
    $ ./bin/gendiff file1.yaml file2.yaml
    ```
[![asciicast](https://asciinema.org/a/9peyUaZIVRNw3Hh8exXuozEGp.svg)](https://asciinema.org/a/9peyUaZIVRNw3Hh8exXuozEGp)

Comparing two json files with recursive structure

    ```
    $ ./bin/gendiff file1.json file2.json
    ```
[![asciicast](https://asciinema.org/a/obmdDQx5zsrLv7HEMzordzeSO.svg)](https://asciinema.org/a/obmdDQx5zsrLv7HEMzordzeSO)

Comparing two json files with use plain formatter
    ```
    $ ./bin/gendiff --format plain file1.json file2.json
    ```
[![asciicast](https://asciinema.org/a/zukLK4J8TRrDDp3B9MXoHUH6U.svg)](https://asciinema.org/a/zukLK4J8TRrDDp3B9MXoHUH6U)

Comparing two files with use json formatter
```
$ ./bin/gendiff --format json file1.json file2.json
```
[![asciicast](https://asciinema.org/a/p8bR72cy8jRU2YgvQ2S5NeoP3.svg)](https://asciinema.org/a/p8bR72cy8jRU2YgvQ2S5NeoP3)

## License
The Bryan Games project is licensed for use under the MIT License (MIT).
Please see [LICENSE](/LICENSE) for more information.