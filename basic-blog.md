# My Journey with Basiq API Integration: A Detailed Walkthrough

## Introduction

Hello fellow PHP developers! I'm John, and I've been on a journey to integrate the Basiq API into a simple web application. The goal? To retrieve account balance information for a specific savings account at a specific bank. I'm familiar with APIs, but I had some difficulty understanding how to use the Basiq dashboard and API. 

I'm running on a Manjaro Linux system, and I've decided to use Docker and Lando for my development environment. This blog post is a comprehensive guide that will take you through my journey, including the commands I ran, the important snippets of information in their output, and the decisions they led to. 

## Phase 1: Familiarisation with Basiq API

The first phase was all about understanding the Basiq API and dashboard. I started with a general overview of the Basiq API and dashboard. I had some specific queries about the Basiq API and dashboard, and I needed a step-by-step guide for Basiq API integration. 

I was unsure about the relationship between the Basiq dashboard and API, how to configure the dashboard, and how to use the API to retrieve account balance information. Thankfully, I received a detailed explanation of the Basiq platform, its dashboard, API, and how they relate to each other. My specific queries about the Basiq dashboard and API were also addressed.

## Phase 2: Setting Up a Local Development Environment

The second phase was all about setting up a local development environment using Docker and Lando. This included setting up a local web server, implementing user authentication, retrieving account balance information, displaying account balance information, and error handling and testing. 

I started by updating my system's package list and installing Docker on my Manjaro Linux system for compatibility with Lando. Here's the commands I used:

Update Package List

```bash
sudo pacman -Syu
```

command updates the package list and upgrades all the system software to the latest version. pacman is the package manager that comes with Manjaro, and it's the most appropriate tool for this task.

```bash
sudo pacman -S docker
```

This command (`-S`) installs Docker. The output was quite lengthy, but here's a snippet:

```bash
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
I started the docker service. This command starts the Docker service. systemctl is a system management command from systemd, which is the init system used in Manjaro. Starting the Docker service is necessary for using Docker to run containers.

```bash
sudo systemctl start docker
```

```
sudo systemctl start docker
```

Enable Docker Service to Start on Boot.
This command sets the Docker service to start automatically at boot. This is important to ensure that Docker is always available when the system starts, even after a reboot.

```bash
sudo systemctl enable docker
```

Verify Docker Installation

This command checks the installed version of Docker. Verifying the Docker version is a good practice to ensure that the installation was successful and that the correct version of Docker is installed.

```bash
docker --version
```

Hello world

This command runs a simple Docker image called hello-world. This is a common way to test a Docker installation. The hello-world image is designed to output a message confirming that Docker is working correctly.

```bash
docker run hello-world
```

Error:

```
Got permission denied while trying to connect to the Docker daemon socket at unix:///var/run/docker.sock: Post http://%2Fvar%2Frun%2Fdocker.sock/v1.40/containers/create: dial unix /var/run/docker.sock: connect: permission denied
```

This error message indicates that my current user doesn't have the necessary permissions to communicate with the Docker daemon. The Docker daemon runs with root privileges, and by default, only the root user and users in the docker group have the permissions to interact with it.

I then proceeded to add my user to the docker group.

This command adds the current user to the docker group. This is necessary to run Docker commands without needing sudo. We confirmed the need for this step by checking the Docker documentation and various Linux user guides.

```bash
sudo usermod -aG docker $USER
```
Scraaatchh, this is where I ran into annoyance and fear.

After running this command, I encountered a user account lockout issue. After failing my password 3 times with sudo I found myself locked out, it was scary. Sudo's message did not update me about the lockout, just that my access failed. Same when I logged out and back in via the GUI, though it usually says.
By using ctrl+alt+F2/F3 and click back and forth between them I was about to drop to a console and see the lockout message. I then waited for 6 minutes hoping that's all it was. 6 minutes later I was able to log back in and rerun the `sudo usermod -aG docker $USER` command, logout and back in again, and then finally check I was in the docker group.

```bash
$ groups                                                                                                                                                                     
```

Output:

```  
sys network power docker lp wheel bevan
```

```bash
docker run hello-world
```

The output confirmed that Docker was installed correctly and running on my system:

```bash
Unable to find image 'hello-world:latest' locally
latest: Pulling from library/hello-world
0e03bdcc26d7: Pull complete 
Digest: sha256:6a65f928fb91fcfbc963f7aa6d57c8eeb426ad9a20c7ee045538ef34847f44f1
Status: Downloaded newer image for hello-world:latest

Hello from Docker!
This message shows that your installation appears to be working correctly.
...

Now I start the hello world docker image again.

Download Lando

Command: curl -OL https://github.com/lando/lando/releases/download/v3.18.0/lando-x64-v3.18.0.pacman
Description: This command downloads the Lando package from the official GitHub releases page. Lando is a development tool that's necessary for this project. We confirmed the compatibility and version by checking the Lando documentation and release notes.
Status: Completed successfully
Output: Lando v3.18.0 downloaded
Install Lando

Command: sudo pacman -U lando-x64-v3.18.0.pacman
Description: This command installs the downloaded Lando package using pacman. This is the standard way to install local package files with pacman.
Status: Completed successfully
Output: Lando v3.18.0 installed
Verify Lando Installation

Command: lando version
Status: Completed successfully
Output: Lando version v3.18.0

Next, I downloaded Lando manually from the GitHub releases page using the following command:

This command downloads the Lando package from the official GitHub releases page. Lando is a development tool that's necessary for this project. We confirmed the compatibility and version by checking the Lando documentation and release notes.

```bash
curl -OL https://github.com/lando/lando/releases/download/v3.18.0/lando-x64-v3.18.0.pacman
```

Install Lando

```bash
sudo pacman -U lando-x64-v3.18.0.pacman
```

I then created a `lando.yml` file for my project. This file is used to configure the Lando environment for the project. Here's a simple example of what the `lando.yml` file might look like:

.lando.yml
```yaml
name: myapp
recipe: lamp
config:
  webroot: .
```

With the .lando.yml file in place, I proceed to start up my project.

```bash
lando start
```

I encountered a missing `libcrypt` library issue with Lando, which prevented me from starting my local development environment. The error message was:

```bash
error while loading shared libraries: libcrypt.so.1: cannot open shared object file: No such file or directory
```

With some assistance, I was able to resolve this issue by installing the missing library:

```bash
sudo pacman -S libxcrypt
```

Start lando again

```bash
lando start                                                                                                                                                                   
```

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
```

However, after resolving this issue, I encountered a warning about an unsupported Docker version and a "Not Found" error when trying to access my site. I'm currently working on resolving these issues.

After successfully setting up Docker and Lando on my Manjaro Linux system, I moved on to the next step of my journey: writing a simple 'Hello World' PHP script and resolving some issues with Lando.

### Writing a 'Hello World' PHP Script

The first task was to create a PHP script that echoes "Hello World!" into `./web/index.php`. This is a simple task, but it's an important step in setting up any new PHP project. Here's how I did it:

```bash
mkdir web
cat <<EOF > ./web/index.php
<?php
echo "Hello World!";
?>
EOF
```

The `mkdir web` command creates a new directory named `web`. The `cat <<EOF > ./web/index.php` command uses the `cat` command with heredoc syntax (`<<EOF`) to create a new file named `index.php` in the `web` directory. The `EOF` markers indicate the start and end of the content to be written to the file. The `>` operator redirects this content into `./web/index.php`, effectively creating the file with the specified content.

After running these commands, I had a file named `index.php` in my `web` directory with the following content:

```php
<?php
echo "Hello World!";
?>
```

I verified this by running `cat ./web/index.php` in my terminal. The output was the content of the PHP script.

### Resolving Lando Issues

You may recall that when I first started lando with `lando start` that I encountered a warning about an unsupported Docker version and a "Not Found" error when trying to access my site. I'm currently working on resolving these issues.

## Review

I now have a better understanding of the Basiq platform and how to use its dashboard and API. I've successfully installed Docker and Lando on my Manjaro Linux system, which are both necessary steps for the upcoming web server setup. I successfully wrote a 'Hello World' PHP script and started to address some issues with Lando.

## Uninstalling Docker and Lando

After successfully setting up Docker and Lando on my Manjaro Linux system, I encountered a warning about an unsupported Docker version. The Docker version installed was 24.0.2, while Lando supports Docker versions in the range of 18.09.3 - 20.10.99. To resolve this, I decided to downgrade Docker to a version compatible with Lando.

The first step was to uninstall the current Docker and Lando installations. Here's how I did it:

```bash
sudo pacman -R lando
sudo pacman -R docker
```

The `sudo pacman -R` command uninstalls a package in Manjaro. I ran this command twice, once for Lando and once for Docker.

The output of these commands indicated that both Lando and Docker were successfully uninstalled:

```
(1/1) removing lando
(1/1) removing docker
```

## Docker Version Compatibility Issue

While setting up Lando, we encountered a Docker version compatibility issue. The version of Docker installed on the system was newer than the one supported by Lando. Lando v3.18.0 supports Docker version 20.10.7, but the system had Docker version 24.0.2 installed. 

### Attempted Solutions

We attempted to downgrade Docker to a compatible version using the package manager, but this proved to be a challenge. Here are the steps we took:

1. **Checked Docker version**: We ran `docker --version` to confirm the installed Docker version. The output was `Docker version 24.0.2, build cb74dfcd85`.

2. **Attempted to downgrade Docker**: We tried to downgrade Docker to version 20.10.7 using the command `sudo pacman -S docker=20.10.7`. However, this command was invalid as pacman does not support version constraints in this format.

3. **Searched for a solution**: We searched for a way to install Docker 20.10.7 on Manjaro or Arch. The recommended solution was to use the `downgrade` utility, which allows you to downgrade a package to a previous version.

4. **Attempted to use the downgrade utility**: We ran `sudo downgrade docker` to try and downgrade Docker. However, this did not provide a list of versions to choose from, as we expected. Instead, it reinstalled the current version of Docker.

5. **Set environment variable for downgrading**: We set the `DOWNGRADE_FROM_ALA` environment variable to 1 to allow downgrading from the Arch Linux Archive (ALA). However, running `sudo downgrade docker` again still did not provide a list of versions to choose from.

### Current Status

At this point, we decided to test if Lando would work with the newer Docker version, despite the compatibility warning. If Lando works as expected, we can continue using the current setup. If not, we will need to find another solution for the Docker version compatibility issue.

We also considered forking and patching Lando to support the new Docker version. This would involve making changes to the Lando codebase, testing the changes, and submitting a pull request to the Lando repository. However, this would be a significant undertaking and would require a good understanding of the Lando codebase.

We might need to revist installing docker from a tag.gz file if necessary. 

Editors note: Here's a bunch of stuff I tried, from ==== to ==== can you please rewrite that in keeping with the existing theme and format and tone of the current blog, just this bit, I will copy paste it back int.

====

`~/workspace/prompts-n-stuff    main  sudo vi /etc/pacman.conf `

Removed `IgnorePkg = docker` by hand.
saved.

I have gone ahead and removed downgrade:
```
    ~/workspace/prompts-n-stuff    main  sudo pacman -R downgrade                                                                                                                                                        ✔  33s  
checking dependencies...

Packages (1) downgrade-11.3.0-1

Total Removed Size:  0.07 MiB

:: Do you want to remove these packages? [Y/n] y
:: Processing package changes...
(1/1) removing downgrade                                                                                                                      [#######################################################################################] 100%
:: Running post-transaction hooks...
(1/2) Arming ConditionNeedsUpdate...
(2/2) Refreshing PackageKit...
```
And the not sure what version of docker we were left with.. the version looks recent.
Maybe downgrade downgraded to the current version (I Have not looked at the point numbers).

Install docker:
```
    ~/workspace/prompts-n-stuff    main  sudo pacman -S docker                                                                                                                                                                   ✔ 
resolving dependencies...
looking for conflicting packages...

Packages (1) docker-1:24.0.2-1

Total Installed Size:  107.27 MiB

:: Proceed with installation? [Y/n] y
(1/1) checking keys in keyring                                                                                                                [#######################################################################################] 100%
(1/1) checking package integrity                                                                                                              [#######################################################################################] 100%
(1/1) loading package files                                                                                                                   [#######################################################################################] 100%
(1/1) checking for file conflicts                                                                                                             [#######################################################################################] 100%
(1/1) checking available disk space                                                                                                           [#######################################################################################] 100%
:: Processing package changes...
(1/1) installing docker                                                                                                                       [#######################################################################################] 100%
Optional dependencies for docker
    btrfs-progs: btrfs backend support [installed]
    pigz: parallel gzip compressor support
    docker-scan: vulnerability scanner
    docker-buildx: extended build capabilities
:: Running post-transaction hooks...
(1/5) Creating system user accounts...
(2/5) Reloading system manager configuration...
(3/5) Reloading device manager configuration...
(4/5) Arming ConditionNeedsUpdate...
(5/5) Refreshing PackageKit...
```

Install docker:
```
    ~/Downloads  sudo pacman -U lando-x64-v3.18.0.pacman                                                                                                                                                                          1 ✘ 
loading packages...
resolving dependencies...
looking for conflicting packages...

Packages (1) lando-3.18.0-1

Total Installed Size:  174.59 MiB

:: Proceed with installation? [Y/n] y
(1/1) checking keys in keyring                                                                                                                [#######################################################################################] 100%
(1/1) checking package integrity                                                                                                              [#######################################################################################] 100%
(1/1) loading package files                                                                                                                   [#######################################################################################] 100%
(1/1) checking for file conflicts                                                                                                             [#######################################################################################] 100%
(1/1) checking available disk space                                                                                                           [#######################################################################################] 100%
:: Processing package changes...
(1/1) installing lando                                                                                                                        [#######################################################################################] 100%
+ LANDO_ROOT=/usr/share/lando
+ PATH=/home/bevan/.local/bin:/usr/local/sbin:/usr/local/bin:/usr/bin:/usr/lib/jvm/default/bin:/usr/bin/site_perl:/usr/bin/vendor_perl:/usr/bin/core_perl:/usr/local/bin
+ TERM=xterm
+ chmod 755 -R /usr/share/lando
+ mkdir -p /usr/local/bin
+ ln -sf /usr/share/lando/bin/lando /usr/local/bin/lando
++ awk -F: '$1 == "sudo" {print $4}' /etc/group
+ SUDOERS=
+ MAX_MAP_COUNT=262144
+ MMC_PARAMETER_PATH=/proc/sys/vm/max_map_count
+ '[' -f /proc/sys/vm/max_map_count ']'
++ sysctl -n vm.max_map_count
+ '[' 262144 -lt 262144 ']'
:: Running post-transaction hooks...
(1/3) Arming ConditionNeedsUpdate...
(2/3) Refreshing PackageKit...
(3/3) Updating the desktop file MIME type cache...
```

Awesome, lando starts with out expected warning:
```
    ~/workspace/basiq  lando start                                                                                                                                                                                                  ✔ 
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
    ✔ https://localhost:32773 [200]
    ✔ http://localhost:32774 [200]
    ✔ http://basiq.lndo.site/ [200]
    ✔ https://basiq.lndo.site/ [200]
```

How do I use curl to output just the response body ?


### Next Steps

For now, we are going to test if Lando works with the newer Docker version. If it does, we will continue with the current setup. If not, we will consider this issue as a separate project and come back to it later.

In the meantime, we can also consider manually installing Docker, which would allow us to control the Docker version independently of the package manager. However, this would require more effort and is not our preferred solution.

We will update this blog post with our findings once we have tested Lando with the newer Docker version.

## Conclusion

Today's journey involved uninstalling Docker and Lando and preparing to install a compatible Docker version. I learned that the package manager in Manjaro does not support installing specific versions of a package, we next need to determine a way to install the reqruied version.

====

Stay tuned for more updates as I continue to navigate this journey.
