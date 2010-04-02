# Modular Gaming

A modular web game framework.

> It is unstable and still developing.

## Requirements

* PHP 5.2+
* Mysql 5.0+
* [Kohana v3.0] (http://github.com/modulargaming/core)
* Kohana Modules

		[A1](http://github.com/modulargaming/A1)
		[A2](http://github.com/modulargaming/A2)
		[ACL](http://github.com/modulargaming/acl)
		[Blog](http://github.com/modulargaming/blog)
		[Captcha](http://github.com/modulargaming/captcha)
		[Database](http://github.com/modulargaming/database)
		[Jelly](http://github.com/modulargaming/jelly 
		[Message](http://github.com/modulargaming/message)
		[Pagination](http://github.com/modulargaming/pagination)

		(**They are all included**)

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

Run the installer and it will automatically build the tables. (TODO for now use mg.sql)


Step 5: Configuration of modulargaming

Open `application/bootstrap.php` and make the following changes: 

* Set the default [timezone](http://php.net/timezones) for your application

Make sure the `application/cache` and `application/logs` directories are world writable with:

 `chmod 0777 application/{cache,logs}`


Now Browse to `yourdomain.com` and you should see the **Home Page**.

> By default, you will need to set your user to have the role 'Admin'.

