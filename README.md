# Raffle

This application is used to select registered attendees of the eventbrite events for phplx meetups.

## Install via Composer


```
git clone https://github.com/phplx/raffle.git
cd raffle
git submodule update --init
// download composer
curl -sS https://getcomposer.org/installer | php
php composer.phar install -o
```

## Run

```
bin/raffle <prize name>
# or
php bin/raffle.php <prize name>
```

[![phplx](https://secure.gravatar.com/avatar/c67d21c0c2ba2be3bfe2c550039fc5d3?s=100)](http://phplx.net)

## LICENSE

Licensed under the [BSD LICENSE](https://github.com/phplx/raffle/blob/master/LICENSE)
