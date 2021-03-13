# Migratory
**Migratory** sends any posts from [esa.io](https://esa.io/) to [Hatena Blog](https://hatenablog.com/).

## Installation
1. Set up esa.io webhook. ( https://docs.esa.io/posts/37 )
   
   Webhook URL is `{$YOUR_APP_DOMAIN}/api/migrate`.  
   This version only support "記事を新規作成した時".

1. Copy code to your server.
1. Set environment variables to your server.
    - APP_DEBUG: Debug mode (true/false)
    - APP_ENV: Your application environment (production/local or other)
    - APP_KEY: Your application hash key (`php artisan key:generate`)
    - APP_URL: Your application url ( e.g. http://localhost )
    - ESA_SECRET: Esa webhook secret
    - HATENA_KEY: Hatena blog API key
    - HATENA_NAME: Your Hatena blog username
    - HATENA_URL: Your Hatena blog domain ( e.g. example.hatenablog.jp )

## Usage
When you ship an article, Migratory send it as a draft article to your Hatena blog.

## For developers
### Installation
```shell
git clone https://github.com/chiroruxx/migratory
cd migratory
cp .env.example .env
./vendor/bin/sail up
./vendor/bin/sail composer install
./vendor/bin/sail artisan key:generate
```
