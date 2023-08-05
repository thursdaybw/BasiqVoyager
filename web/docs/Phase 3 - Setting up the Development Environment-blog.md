


# My Adventure with Basiq API Integration: A Comprehensive Guide

## Introduction

Greetings, fellow PHP developers! I'm John, and I've embarked on a journey to integrate the Basiq API into a straightforward web application. The objective? To fetch account balance details for a specific savings account from a specific bank. Although I'm well-versed with APIs, I found the Basiq dashboard and API somewhat challenging to comprehend. I'm operating on a Manjaro Linux system and have chosen Docker and Lando as my development environment. This blog post is a thorough guide that will walk you through my journey, including the commands I executed, the critical information snippets from their output, and the decisions they led to.

## Part 1: Understanding the Basiq API

The initial phase was all about getting to grips with the Basiq API and dashboard. I began with a broad overview of the Basiq API and dashboard. I had some specific questions about the Basiq API and dashboard and needed a step-by-step guide for Basiq API integration. I was uncertain about the relationship between the Basiq dashboard and API, how to configure the dashboard, and how to use the API to fetch account balance information. Fortunately, I received a detailed explanation of the Basiq platform, its dashboard, API, and how they relate to each other. My specific queries about the Basiq dashboard and API were also addressed.

## Part 2: Setting Up a Local Development Environment

The second phase was all about setting up a local development environment using Docker and Lando. This included setting up a local web server, implementing user authentication, retrieving account balance information, displaying account balance information, and error handling and testing. I started by updating my system's package list and installing Docker on my Manjaro Linux system for compatibility with Lando. Here are the commands I used:

Update Package List

This command updates the package list and upgrades all the system software to the latest version. pacman is the package manager that comes with Manjaro, and it's the most appropriate tool for this task.

```
sudo pacman -Syu
```

Instll Docker

```
sudo pacman -S docker
```

The output was quite lengthy, but here's a snippet:

```
:: Synchronizing package databases...
 core is up to date
 extra is up to date
 community is up to date
:: Starting full system upgrade...
resolving dependencies...
looking for conflicting packages...
Packages (2) containerd-1.4.3-1  docker-1:20.10.2-1
Total Download Size:   90.74 MiB
Total Installed Size:  383.56 MiB

:: Proceed with installation? [Y/n] Y
:: Retrieving packages...
 containerd-1.4.3-1-x86_64 downloading...
 docker-1:20.10.2-1-x86_64 downloading...
:: Running post-transaction hooks...
(1/1) Arming ConditionNeedsUpdate...
```
Start the docker service

I then started the Docker service. This command starts the Docker service. systemctl is a system management command from systemd, which is the init system used in Manjaro. Starting the Docker service is necessary for using Docker to run containers.

```
sudo systemctl start docker
```

Enable Docker service to start on boot

This command sets the Docker service to start automatically at boot. This is important to ensure that Docker is always available when the system starts, even after a reboot.

```
sudo systemctl enable docker
```

Verify Docker installation

This command checks the installed version of Docker. Verifying the Docker version is a good practice to ensure that the installation was successful and that the correct version of Docker is installed.

```
docker --version
```

Hello world

This command runs a simple Docker image called hello-world. This is a common way to test a Docker installation. The hello-world image is designed to output a message confirming that Docker is working correctly.

```
docker run hello-world
```

However, I encountered a permission denied error, indicating that my current user didn't have the necessary permissions to communicate with the Docker daemon. I then added my user to the Docker group:

Error:

```
Got permission denied while trying to connect to the Docker daemon socket at unix:///var/run/docker.sock: Post http://%2Fvar%2Frun%2Fdocker.sock/v1.40/containers/create: dial unix /var/run/docker.sock: connect: permission denied
```

This error message indicates that my current user doesn't have the necessary permissions to communicate with the Docker daemon. The Docker daemon runs with root privileges, and by default, only the root user and users in the docker group have the permissions to interact with it.

I then proceeded to add my user to the docker group.

This command adds the current user to the docker group. This is necessary to run Docker commands without needing sudo. We confirmed the need for this step by checking the Docker documentation and various Linux user guides.

Add user to Docker group

```
sudo usermod -aG docker $USER
```

After running this command, I encountered a user account lockout issue after failing my password three times with sudo. I found myself locked out, which was quite alarming. However, after waiting for six minutes, I was able to log back in, rerun the `sudo usermod -aG docker $USER` command, log out and back in again, and then finally check I was in the Docker group:

Check we are in the docker group.

```
$ groups
```

Output:
```
sys network power docker lp wheel bevan
```

Excellent we can see docker in the list of groups.

I ran the Hello World Docker image again:

```
docker run hello-world
```

The output confirmed that Docker was installed correctly and running on my system:

```
Unable to find image 'hello-world:latest' locally
latest: Pulling from library/hello-world
0e03bdcc26d7: Pull complete
Digest: sha256:6a65f928fb91fcfbc963f7aa6d57c8eeb426ad9a20c7ee045538ef34847f44f1
Status: Downloaded newer image for hello-world:latest
Hello from Docker!
This message shows that your installation appears to be working correctly.
```

Next, I downloaded Lando manually from the GitHub releases page using the following command:

```
curl -OL https://github.com/lando/lando/releases/download/v3.1.8-0/lando-x64-v3.1.8-0.pacman
```

I then created a `lando.yml` file for my project. This file is used to configure the Lando environment for the project. Here's a simple example of what the `lando.yml` file might look like:

```yaml
name: basiq 
recipe: lamp
config:
  php: '8.1'
  webroot: ./web
  database: mariadb
```

With the `lando.yml` file in place, I proceeded to start up my project:

```
lando start
```

I encountered a missing `libcrypt` library issue with Lando, which prevented me from starting my local development environment. The error message was:

```
error while loading shared libraries: libcrypt.so.1: cannot open shared object file: No such file or directory
```

With some assistance, I was able to resolve this issue by installing the missing library:

```
sudo pacman -S libxcrypt
```

I started Lando again:

```
lando start
```

I encountered a warning about an unsupported Docker version and a "Not Found" error when trying to access my site.
I spent some time investigating downgrading the docker version, the only way on manjaro appears to be as a tar.gz.

I have a separate blog post all about it.

Here is the output that contains the warning:

```
Let's get this party started! Starting app basiq...
landoproxyhyperion5000gandalfedition_proxy_1 is up-to-date

  _      __              _           __
 | | /| / /__ ________  (_)__  ___ _/ /
 | |/ |/ / _ `/ __/ _ \/ / _ \/ _ `/_/ 
 |__/|__/\_,_/_/ /_//_/_/_//_/\_, (_)  
                             /___/     

Your app is starting up but we have already detected some things you may wish to investigate.
These only may be a problem.


 ■ Using an unsupported version of DOCKER ENGINE
   You have version 24.0.2 but Lando wants something in the 18.09.3 - 20.10.99 range.
   If you have purposefully installed an unsupported version and know what you are doing
   you can probably ignore this warning. If not we recommend you use a supported version
   as this ensures we can provide the best support and stability.
   https://docs.docker.com/engine/install/


Here are some vitals:

 NAME      basiq                       
 LOCATION  /home/bevan/workspace/basiq 
 SERVICES  appserver, database         
 URLS                                  
  ✔ APPSERVER URLS
    ✔ https://localhost:32773 [404]
    ✔ http://localhost:32774 [404]
    ✔ http://basiq.lndo.site/ [404]
    ✔ https://basiq.lndo.site/ [404]

After successfully setting up Docker and Lando on my Manjaro Linux system, I moved on to the next step of my journey: writing a simple "Hello World" PHP script and resolving some issues with Lando.
```

## Writing a "Hello World" PHP Script

The first task was to create a PHP script that echoes "Hello World" into `web/index.php`. This is a simple task, but it's an important step in setting up any new PHP project. Here's how I did it:

```
mkdir web
cat <<EOF > web/index.php
<?php
echo 'Hello, World!';
EOF
```

After running these commands, I had a file named `index.php` in my `web` directory with the following content:

```php
<?php
echo 'Hello, World!';
```

I verified this by running `cat web/index.php` in my terminal. The output was the content of the PHP script.

## Resolving Lando Issues

You may recall that when I first started Lando with `lando start`, I encountered a warning about an unsupported Docker version and a "Not Found" error when trying to access my site. I'm currently working on resolving these issues.

## Review

I now have a better understanding of the Basiq platform and how to use its dashboard and API. I've successfully installed Docker and Lando on my Manjaro Linux system, which are both necessary steps for the upcoming web server setup. I successfully wrote a "Hello World" PHP script and started to address some issues with Lando.

## Uninstalling Docker and Lando

After successfully setting up Docker and Lando on my Manjaro Linux system, I encountered a warning

 about an unsupported Docker version. The Docker version installed was 24.0.2, while Lando supports Docker versions in the range of 18.09.3 - 20.10.99. To resolve this, I decided to downgrade Docker to a version compatible with Lando. The first step was to uninstall the current Docker and Lando installations. Here's how I did it:

```
sudo pacman -R lando
sudo pacman -R docker
```

The output of these commands indicated that both Lando and Docker were successfully uninstalled.

## Docker Version Compatibility Issue

While setting up Lando, we encountered a Docker version compatibility issue. The version of Docker installed on the system was newer than the one supported by Lando. Lando v3.1.8-0 supports Docker version 20.10.7, but the system had Docker version 24.0.2 installed.

## Attempted Solutions

We attempted to downgrade Docker to a compatible version using the package manager, but this proved to be a challenge. Here are the steps we took:

- Checked Docker version: We ran `docker version` to confirm the installed Docker version. The output was `Docker version 24.0.2, build cb74dfcd85`.
- Attempted to downgrade Docker: We tried to downgrade Docker to version 20.10.7 using the command `sudo pacman -S docker=20.10.7`. However, this command was invalid as Pacman does not support version constraints in this format.
- Searched for a solution: We searched for a way to install Docker 20.10.7 on Manjaro or Arch. The recommended solution was to use the `downgrade` utility, which allows you to downgrade a package to a previous version.
- Attempted to use the `downgrade` utility: We ran `sudo downgrade docker` to try and downgrade Docker. However, this did not provide a list of versions to choose from, as we expected. Instead, it reinstalled the current version of Docker.
- Set environment variable for downgrading: We set the `DOWNGRADE_FROM_ALA` environment variable to 1 to allow downgrading from the Arch Linux Archive (ALA). However, running `sudo downgrade docker` again still did not provide a list of versions to choose from.

## Current Status

At this point, we found that Lando works with the newer Docker version, despite the compatibility warning. AS Lando works as expected, we can continue using the current setup. We also considered forking and patching Lando to support the new Docker version. This would involve making changes to the Lando codebase, testing the changes, and submitting a pull request to the Lando repository. However, this would be a significant undertaking and would require a good understanding of the Lando codebase. We might need to revisit installing Docker from a .tar.gz file if we find issues down the track.

## Next Steps

Close off phase 2 and start on Phase 3 - Writing real code / Accessing the API. 

## Commands Used and Their Outputs

## Commands Used and Their Outputs

1. Update package list and install Docker
   - Command: `sudo pacman -Syu; sudo pacman -S docker`
   - Output: `Synchronizing package databases... core is up to date extra is up to date community is up to date Starting full system upgrade... resolving dependencies... looking for conflicting packages... Packages (2) containerd-1.4.3-1  docker-1:20.10.2-1 Total Download Size:    90.74 MiB Total Installed Size:  383.56 MiB :: Proceed with installation? [Y/n] y`
   - Decision: Proceed with Docker installation.

2. Start Docker service and enable it to start on boot
   - Command: `sudo systemctl start docker; sudo systemctl enable docker`
   - Output: No output, commands executed successfully.
   - Decision: Proceed with Docker setup.

3. Verify Docker installation
   - Command: `docker version; docker run hello-world`
   - Output: `Docker version 24.0.2, build cb74dfcd85; Unable to find image 'hello-world:latest' locally latest: Pulling from library/hello-world 0e03bdcc26d7: Pull complete Digest: sha256:6a65f928fb91fcfbc963f7aa6d57c8eeb426ad9a20c7ee045538ef34847f44f1 Status: Downloaded newer image for hello-world:latest Hello from Docker! This message shows that your installation appears to be working correctly.`
   - Decision: Docker is installed correctly, proceed to next step.

4. Download Lando
   - Command: `curl -OL https://github.com/lando/lando/releases/download/v3.18.0/lando-x64-v3.18.0.pacman `
   - Output: `lando vv3.18.0 downloaded`
   - Decision: Proceed with Lando installation.

6. Start Lando
   - Command: `lando start`
   - Output: `error while loading shared libraries: libcrypt.so.1: cannot open shared object file: No such file or directory`
   - Decision: Install missing `libcrypt` library.

7. Install `libcrypt` library
   - Command: `sudo pacman -S libxcrypt`
   - Output: `libcrypt installed`
   - Decision: Start Lando again.

8. Start Lando again
   - Command: `lando start`
   - Output: `Warning about unsupported Docker version and "Not Found" error when trying to access site`
   - Decision: Attemtp Resolve Docker version compatibility issue.

9. Uninstall Docker and Lando
   - Command: `sudo pacman -R lando; sudo pacman -R docker`
   - Output: `Lando and Docker uninstalled`
   - Decision: Prepare to install compatible Docker version.

10. Attempt to downgrade Docker
    - Command: `sudo pacman -S docker=20.10.7`
    - Output: `invalid command, Pacman does not support version constraints in this format`
    - Decision: Search for a solution to install Docker 20.10.7 on Manjaro or Arch.

11. Attempt to use `downgrade` utility
    - Command: `sudo downgrade docker`
    - Output: `reinstalled current version of Docker, did not provide list of versions to choose from`
    - Decision: Set `DOWNGRADE_FROM_ALA` environment variable to 1.

12. Set `DOWNGRADE_FROM_ALA` environment variable to 1
    - Command: `export DOWNGRADE_FROM_ALA=1; sudo downgrade docker`
    - Output: `variable was set`
    - Decision: Attempt to donwgrade docker.

13. Install Docker
   - Command: `sudo downgrade docker`
   - Output: `still did not provide list of versions to choose from, but asked to set ignorePkg to true, I said yes. Docker is still at version 24, weird. There is information about the Arch repository not having downgrades blocked on stable releases`
   - Decision: Proceed to uninstall downgrade and docker

14. Uninstall `downgrade` utility
   - Command: `sudo pacman -R downgrade`
   - Output: `downgrade uninstalled`

15. Uninstall Docker
   - Command: `sudo pacman -R docker`
   - Output: `Docker uninstalled`

16. Install docker from repo
   - Command: `sudo pacman -S docker`
   - Output: `User input request to proced when ignorePkg=true`
   - Decision: Bail out, remove the ignorePgk=docker from pacman config.

17. Use vim to delete the ignorePkg from pacman config
   - File: `/etc/pacman.conf`
   - Output: `User input request to proced when ignorePkg=docker`
   - Decision: Bail out, remove teh ignorePgk=docker

18. Install docker from repo
   - Command: `sudo pacman -S docker`
   - Output: `Installed successfully`
   - Decision: Move on to setting up docker

19. Start Docker service and enable it to start on boot
   - Command: `sudo systemctl start docker; sudo systemctl enable docker`
   - Output: No output, commands executed successfully.
   - Decision: Proceed with Docker setup.

20. Verify Docker installation
   - Command: `docker version; docker run hello-world`
   - Output: Success
   - Decision: Docker is installed correctly, proceed to checking website response.

21. Start Lando
   - Command: `lando start`
   - Output: `Warning about unsupported Docker version`
   - Decision: Ignore it, move on to testing the website.

22. Test if Lando works with the newer Docker version
   - Command: `curl -i http://basiq.lndo.site/`
   - Output: 
     ```
     HTTP/1.1 200 OK
     Content-Length: 12
     Content-Type: text/html; charset=UTF-8
     Date: Fri, 04 Aug 2023 11:24:33 GMT
     Server: Apache/2.4.56 (Debian)
     X-Powered-By:

## Next Steps

1. Test if Lando works with the newer Docker version.
2. If Lando does not work as expected, we will need to investigate further.
3. Consider manually installing Docker to control the Docker version independently of the package manager.

## Loose Ends

1. Docker version compatibility issue with Lando.

## Recommended Next Steps

1. Test if Lando works with the newer Docker version.
2. If Lando does not work as expected, consider this issue as a separate project and come back to it later.
3. Consider manually installing Docker to control the Docker version independently of the package manager.
4. Update this blog post with findings once Lando has been tested with the newer Docker version.

## Conclusion

Today's journey involved uninstalling Docker and Lando and preparing to install a compatible Docker version. I learned that the package manager in Manjaro does not support installing specific versions of a package. We next need to determined that the only way to install the correct version was with a tarball. I decided instead to douible check that the site could function while operating with the warning.
