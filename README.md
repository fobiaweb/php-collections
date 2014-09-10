# PHP Collections

Списки элементов. Позволяет работать сразу над всеми элементами, фильтравать, устанавливать и извлекать их свойства.


## Installation

PHP Object Collection can be installed with [Composer](http://getcomposer.org)
by adding it as a dependency to your project's composer.json file.

```json
{
    "require": {
        "fobia/php-collections": "*"
    }
}
```

Please refer to [Composer's documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction)
for more detailed installation and usage instructions.


## TODO

- [X] `eq` - Получить элемент по индексу
- [X] `find` - Найти все элементы, параметр которых удовлетворяют условию.
- [X] `filter` - Отфильтровать список элементов используя функции обратного вызова.
- [X] `each` - Обходит весь список приминяя callback функцию
