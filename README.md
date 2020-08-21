# URL shortener in PHP + Shorten URLs management in MVC

## Use case

In any case, the user enters a long URL named `longUrl`, this is the redirect link.

Then, the two use cases are: (do not expire)

* The user wants to use an alias  
    **longUrl** _https://www.google.com_  
    **shortUrl** https://www.avim.eu/*__googl__*

* The user wants to use a random alias (can be expires)  
    **longUrl** _https://www.google.com_  
    **shortUrl** https://www.avim.eu/*__e46dsh__*

## Manage

According to management, a special url is allowed.
In fact, the url `/app/index.php` redirect you into a GUI that's allow you to manage all shorten url

## Changelog

* See [here](CHANGELOG.md)

## Author

* [Avi Mimoun](https://www.github.com/av1m)

## Repository available on Github

* [Link of this repository](https://github.com/w0b/routing)

## License

* [MIT](https://github.com/w0b/routing/blob/master/LICENSE)