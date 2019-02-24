# migratory
`migratory` sends any posts from [esa.io](https://esa.io/) to [Hatena Blog](https://hatenablog.com/).

## installation
```
$ cd src
$ composer install
$ cp .env.example .env
```

And...  

> The next thing you should set your application key to a random string. Typically, this string should be 32 characters long.

## For developer
### run
```
$ php -S localhost:8000 -t src/public
```
