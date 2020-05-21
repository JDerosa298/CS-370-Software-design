To begin, please run the provided install script and follow any instructions that appear. It may ask to install some dependencies.

While this is happening, it will ask you to create a default judge user. This user will allow you to log in to the web interface and register users and problems.

Alternatively, you can register new users through the command line with the 'user' command.

After this process has completed, please install web server software of your choice (such as apache2) and copy the files from the ~/dsp/web directory to your web directory (for example, /var/www/html/).

PHP is necessary for the software to function correctly. If it's not already installed, please install the latest version available.

You can start the server again by running ~/dsp/server.jar with Java. Version 1.10 is recommended.

There are a few more useful commands available from the command line:
    user : commands pertaining to the registration and editing of users
    help : gives more detailed help messages, including proper command syntax
    exit : stops the server

Once both the web server and java server are installed and running, navigate to http://127.0.0.1 with your web browser.

If everything has been installed successfully, you should see a screen asking you to log in.
