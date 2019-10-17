# My website 'lismoica'
This project is my attempt to re-do my original cinema blog: lismoica.blogspot.com
To do so, I use Symfony 4 and Docker. I code on PHP Storm.

As it was a long time ago since I have coded (and PHP might be 3 years ago), I will document every steps in the document LEARNME.
Please keep it mind that this document and overall project is solely for a personal purpose (which is why the document might have informal language).

#What you need to run the project:
1. PHP 7.3.10
2. Composer 1.9.0
3. Docker 19.03.2
4. Symfony 4.7.3

#Steps to run the project:
1. Inside your project folder, use your CLI to run: $ php bin/console server:run
2. Launch Docker and run successively the following commands: $docker-compose down $docker-compose up -d
3. Check if your website and phpmyadmin are live by going to localhost:8000 and localhost:8080; and you are good to go!


