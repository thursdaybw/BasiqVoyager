# Connecting to the Basiq API and Retrieving Personal Account Balance

# Part 1: Setting Up a Local Development Environment for Lando and Docker on Manjaro Linux

In this blog post, we'll walk you through our journey from conception to completino of the connectin to the BasiQ API via PHP. Including initial research, setting up a local development environment for Lando and Docker on Manjaro Linux. We'll share the steps we took, the decisions we made, and the challenges we encountered. Our goal is to provide a comprehensive guide that not only helps you replicate our setup but also gives you insights into our thought processes and decision-making along the way.

## Introduction

Our journey began with utilising ChatGPT and the Voxscript plugin to research available APIs in Australia. ulimtately deciding on Basiq being a great and all but only option. I then moved on to utilising ChatGPT once again to get familiar with Basiq and the relationship between the Dashboard and the API endpoints, and get a good picture of the general workflow.

Having a general understanding of basic, it's time to start setting up our project using "Lando development" on the web. We used DuckDuckGo, a privacy-focused search engine, to find relevant links. Two prominent results caught our attention: the official Lando website https://lando.dev/ and its GitHub repository https://github.com/lando/lando.

Our journey began with a search for "Lando development" on the web. We used DuckDuckGo, a privacy-focused search engine, to find relevant links. Two prominent results caught our attention: the official Lando website https://lando.dev/ and its GitHub repository https://github.com/lando/lando.

From past experience, we knew that the GitHub repository often hosts the most up-to-date releases. However, we decided to explore the official Lando site first for good measure. We navigated to the 'Docs' section, then to 'Getting Started', and finally landed on the 'Installation' page https://docs.lando.dev/getting-started/installation.html.

   [Lando Installation Guide](https://docs.lando.dev/getting-started/installation.html)

   The Lando documentation provides a detailed guide on how to install Lando on different operating systems. It recommends installing Docker via direct download for Linux users. However, it also mentions that Docker can be installed via the package manager of the Linux distribution. The guide also provides system requirements, preflight checks, and hardware requirements for running Lando.

   Excerpt from the documentation:
   ```
   Install package via direct download (recommended)
   - Install the Docker Community Edition for your Linux version. Visit https://get.docker.com for the quick, easy install script. At least version 19.03.1-ce.
   - Install Docker Compose.
   - Download the latest .deb, .pacman, or .rpm package from GitHub.
   - Double click on the package and install via your distribution's software center or equivalent.
   - Make sure you look at the caveats below and follow them appropriately.
   ```

Here, we found that Lando recommends installing Docker via direct download. However, being Linux enthusiasts, we value good system hygiene and prefer to use Manjaro's package manager, pacman, for installations. This ensures that all installed packages are tracked and managed efficiently, reducing the risk of system clutter and conflicts.

2. [Docker Post-installation steps for Linux](https://docs.docker.com/engine/install/linux-postinstall/)

   This guide provides instructions on how to manage Docker as a non-root user, and how to configure Docker to start on boot. It also provides information on how to use systemd to manage Docker.

   Excerpt from the documentation:
   ```
   Manage Docker as a non-root user
   - Create the docker group if it does not exist: sudo groupadd docker
   - Add your user to the docker group: sudo usermod -aG docker $USER
   - Log out and log back in so that your group membership is re-evaluated.

   Configure Docker to start on boot
   - Most current distributions (RHEL, CentOS, Fedora, Ubuntu 16.04 and higher) use systemd to manage which services start when the system boots. Ubuntu 14.10 and below use upstart.
   - systemd: $ sudo systemctl enable docker.service
   - upstart: $ echo manual | sudo tee /etc/init/docker.override
   - chkconfig: $ sudo chkconfig docker on
   ```

3. [Docker Command Line Interface (CLI)](https://docs.docker.com/engine/reference/commandline/cli/)

   This guide provides a comprehensive list of Docker CLI commands, including the command to verify the Docker installation: `docker version`.

   Excerpt from the documentation:
   ```
   docker version: This command shows the Docker version information. This is useful when you want to know exactly which version of Docker you're running.
   ```
   
With Docker successfully installed via pacman, we were ready to move on to the next phase of our journey: installing Lando. But that's a story for another time.

In this process, we demonstrated the importance of using trusted sources for software installation, the value of using a package manager for system hygiene, and the need for a bit of trust in the tools we use.

## Actions Taken

In the early stages of our journey, we took several actions to understand the Basiq platform, its dashboard, API, and how they relate to each other. We addressed specific queries about the Basiq dashboard and API and provided a general step-by-step guide on how to use the Basiq dashboard and API to retrieve account balance information. Unfortunately, we failed to document these actions in detail at the time. However, we intend to revisit this topic and provide a more detailed account in a future blog post.

## Setting Up the Development Environment

Next, we moved on to setting up the development environment. Here's a detailed account of the commands we ran, their purpose, and their outcomes:

1. **Update Package List**
   - Command: `sudo pacman -Syu`
   - Description: This command updates the package list and upgrades all the system software to the latest version. `pacman` is the package manager that comes with Manjaro, and it's the most appropriate tool for this task. We confirmed the version compatibility by checking the Manjaro and software documentation.
   - Status: Completed successfully
   - Output: System package list updated

2. **Install Docker**
   - Command: `sudo pacman -S docker`
   - Description: This command installs Docker using the `pacman` package manager. Docker is necessary for running applications in isolated containers, which is a requirement for this project. We confirmed Docker's compatibility with the current system and its version by checking the Docker and Manjaro documentation.
   - Status: Completed successfully
   - Output: Docker installed

3. **Start Docker Service**
   - Command: `sudo systemctl start docker`
   - Description: This command starts the Docker service. `systemctl` is a system management command from `systemd`, which is the init system used in Manjaro. Starting the Docker service is necessary for using Docker to run containers.
   - Status: Completed successfully
   - Output: Docker service started

4. **Enable Docker Service to Start on Boot**
   - Command: `sudo systemctl enable docker`
   - Description: This command sets the Docker service to start automatically at boot. This is important to ensure that Docker is always available when the system starts, even after a reboot.
   - Status: Completed successfully
   - Output: Docker service set to start on boot

5. **Verify Docker Installation**
   - Command: `docker --version`
   - Description: This command checks the installed version of Docker. Verifying the Docker version is a good practice to ensure that the installation was successful and that the correct version of Docker is installed.
   - Status: Completed successfully
   - Output: Docker version 24.0.2

6. **Test Docker Installation**
   - Command: `docker run hello-world`
   - Description: This command runs a simple Docker image called `hello-world`. This is a common way to test a Docker installation. The `hello-world` image is designed to output a message confirming that Docker is working correctly.
   - Status: Completed successfully
   - Output: Docker hello-world image ran successfully

7. **Add User to Docker Group**
   - Command: `sudo usermod -aG docker $USER`
   - Description: This command adds the current user to the `docker` group. This is necessary to run Docker commands without needing `sudo`. We confirmed the need for this step by checking the Docker documentation and various Linux user guides.
   - Status: Completed successfully
   - Output: User added to Docker group

8. **Download Lando**
   - Command: `curl -OL https://github.com/lando/lando/releases/download/v3.18.0/lando-x64-v3.18.0.pacman`
   - Description: This command downloads the Lando package from the official GitHub releases page. Lando is a development tool that's necessary for this project. We confirmed the compatibility and version by checking the Lando documentation and release notes.
   - Status: Completed successfully
   - Output: Lando v3.18.0 downloaded

9. **Install Lando**
   - Command: `sudo pacman -U lando-x64-v3.18.0.pacman`
   - Description: This command installs the downloaded Lando package using `pacman`. This is the standard way to install local package files with `pacman`.
   - Status: Completed successfully
   - Output: Lando v3.18.0 installed

10. **Verify Lando Installation**
    - Command: `lando version`
    - Status: Completed successfully
    - Output: Lando version v3.18.0

## Conclusion

The journey of setting up a local development environment for Lando and Docker on Manjaro Linux was filled with learning, problem-solving, and decision-making. We hope that this blog post provides you with a comprehensive guide to replicate our setup and gives you insights into our thought processes and decision-making along the way.

In the next part of this series, we'll revisit our actions related to the Basiq platform, its dashboard, API, and how they relate to each other. We'll provide a more detailed account of our actions and decisions, so stay tuned
