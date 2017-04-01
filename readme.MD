Adds a webhooks useful for testing

    composer require --dev dam1r89/test-hooks

## Configuration:

config/app.php
	
	dam1r89\TestHooks\TestHooksServiceProvider::class,

Publish

	php artisan vendor:publish --tag="testhooks"

by default it works only on `testing` and `local` environment.



## Methods

Supports only mysql database.

Method | Route | Params | Explanation
--- | --- | --- | ---
GET | /test-hooks/db | | Return list of all states
PUT | /test-hooks/db | **force** - overrides previous state, **state** - state name  | Store state
PUT | /test-hooks/db/restore | **state** - state name | Restore previously saved state
GET | /test-hooks/date | | Get curren test date
PUT | /test-hooks/date | **date** - in format '2017-04-01 13:00:13' | Set testing date 
DELETE | /test-hooks/date | | Clear test date

## Extension

With extension you can do it from chrome browser. Get it [here](https://chrome.google.com/webstore/detail/test-hooks/fiojdbbkhjjmppeppemgckijlngdhlha)

![preview](https://cloud.githubusercontent.com/assets/3540487/24579737/2bb7568a-16fb-11e7-8c33-d21d47574526.gif)
