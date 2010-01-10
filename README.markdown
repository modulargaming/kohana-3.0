# Modular Gaming

A modular web game framework.

> It is unstable and still developing.

## Requirements

* PHP 5.2+
* Mysql 5.0+
* [Kohana v3.0](http://github.com/kohana/kohana)
* Kohana Modules: [Database](http://github.com/kohana/database), [Sprig](http://github.com/kohana/sprig), [Auth](http://github.com/copy112/A1), [Pagination](http://github.com/kohana/pagination) and [Blog] (http://github.com/copy112/mg-blog), [Captcha](http://github.com/modulargaming/captcha)  . (**They are all included**)

## Installation

Step 1: Download Modular Gaming!

Using your console, to get it from git execute the following command in the root of your development environment:

	$ git clone git://github.com/modulargaming/modulargaming.git

And watch the git magic...

Of course you can always download the code from the [github project](http://github.com/modulargaming/modulargaming) as an archive.

Step 2: Initial Structure

Next the submodules must be initialized:

	$ git submodule init
	
Now that the submodules are added, update them:

	$ git submodule update

That's all there is to it.

Step 3: Configuration of Database

Edit `application/config/database.php` with the correct information.

Step 4: Import SQL

Run migration module on the models.

Step 5: Configuration of modulargaming

Open `application/bootstrap.php` and make the following changes: 

* Set the default [timezone](http://php.net/timezones) for your application

* Set the base_url 

Make sure the `application/cache` and `application/logs` directories are world writable with `chmod application/{cache,logs} 0777`


Now Browse to `yourdomain.com` and you should see the **Home Page**.

> By default, the first registered user has Administrator privilege.

