# Assignment name: Visual Studio Code Installation

## Executive Summary 

As part of our ongoing project, we've identified the need for a robust IDE to facilitate the development process. The decision has been made to install Visual Studio Code on the Manjaro system. This document outlines the steps taken and the plan for this installation.

As part of the preparation for installing Visual Studio Code on the Manjaro system, we performed a system update using the pacman package manager. This document outlines the steps taken and the results of this update.

## User's system information

- Desktop Environment: KDE Plasma version is 5.27.6.
- Shell: Bash (although it seems like you might also be using Zsh, as indicated by the prompt)
- Manjaro Version: 6.1.41-1-MANJARO
- Type: Desktop
- Installed Packages: Visual Studio Code (code 1.79.2-1) is installed

## Plan: 

1. **Update System Packages**
   - Status: Completed
2. **Install Visual Studio Code**
   - Status: Pending

## Actions Taken 

### Update System Packages

Command: `sudo pacman -Syu`

- `sudo`: This command allows for administrative or "superuser" operations. It's necessary for tasks that require higher privileges than those granted to standard users.
- `pacman`: This is the package manager used by Manjaro and other Arch Linux-based distributions. It allows for installing, updating, and removing software on the system.
- `-Syu`: These are options passed to the `pacman` command. `S` stands for sync, `y` for refresh, and `u` for system upgrade. Together, they update the package database and upgrade all out-of-date packages.

Relevant Output:

- The system synchronized its package databases. The `core`, `extra`, `community`, and `multilib` databases are all up to date.
- The system started a full system upgrade. It found one package to upgrade: `brave-browser`.
- The `brave-browser` package was upgraded from version 1.56.19-1 to version 1.56.20-1.
- The system used Timeshift to create a snapshot before the upgrade. This is a useful feature that allows the system to be rolled back to a previous state in case something goes wrong with the upgrade.
- The system updated the GRUB bootloader with the new snapshot information.

Entire outout:

```bash
~/workspace/BasiqVoyager/web$ sudo pacman -S code                                                                                                                 
[sudo] password for bevan: 
Sorry, try again.
[sudo] password for bevan: 
resolving dependencies...
looking for conflicting packages...

Packages (6) c-ares-1.19.1-1  electron22-22.3.18-1  jsoncpp-1.9.5-2  ripgrep-13.0.0-3  woff2-1.0.2-4  code-1.79.2-1

Total Download Size:    74.37 MiB
Total Installed Size:  294.26 MiB

:: Proceed with installation? [Y/n] y
:: Retrieving packages...
 electron22-22.3.18-1-x86_64                                                                                       58.2 MiB  6.23 MiB/s 00:09 [#######################################################################################] 100%
 code-1.79.2-1-x86_64                                                                                              14.5 MiB  6.34 MiB/s 00:02 [#######################################################################################] 100%
 ripgrep-13.0.0-3-x86_64                                                                                         1312.0 KiB  5.72 MiB/s 00:00 [#######################################################################################] 100%
 c-ares-1.19.1-1-x86_64                                                                                           206.8 KiB  4.04 MiB/s 00:00 [#######################################################################################] 100%
 jsoncpp-1.9.5-2-x86_64                                                                                           151.4 KiB  3.36 MiB/s 00:00 [#######################################################################################] 100%
 woff2-1.0.2-4-x86_64                                                                                              57.3 KiB  2.43 MiB/s 00:00 [#######################################################################################] 100%
 Total (6/6)                                                                                                       74.4 MiB  6.18 MiB/s 00:12 [#######################################################################################] 100%
(6/6) checking keys in keyring                                                                                                                [#######################################################################################] 100%
(6/6) checking package integrity                                                                                                              [#######################################################################################] 100%
(6/6) loading package files                                                                                                                   [#######################################################################################] 100%
(6/6) checking for file conflicts                                                                                                             [#######################################################################################] 100%
(6/6) checking available disk space                                                                                                           [#######################################################################################] 100%
:: Processing package changes...
(1/6) installing c-ares                                                                                                                       [#######################################################################################] 100%
(2/6) installing woff2                                                                                                                        [#######################################################################################] 100%
(3/6) installing jsoncpp                                                                                                                      [#######################################################################################] 100%
Optional dependencies for jsoncpp
    jsoncpp-doc: documentation
(4/6) installing electron22                                                                                                                   [#######################################################################################] 100%
Optional dependencies for electron22
    kde-cli-tools: file deletion support (kioclient5) [installed]
    libappindicator-gtk3: StatusNotifierItem support
    pipewire: WebRTC desktop sharing under Wayland [installed]
    qt5-base: enable Qt5 with --enable-features=AllowQt [installed]
    trash-cli: file deletion support (trash-put)
    xdg-utils: open URLs with desktop’s default (xdg-email, xdg-open) [installed]
(5/6) installing ripgrep                                                                                                                      [#######################################################################################] 100%
(6/6) installing code                                                                                                                         [#######################################################################################] 100%
Optional dependencies for code
    bash-completion: Bash completions
    zsh-completions: ZSH completitons [installed]
    x11-ssh-askpass: SSH authentication [installed]
:: Running post-transaction hooks...
(1/3) Arming ConditionNeedsUpdate...
(2/3) Refreshing PackageKit...
(3/3) Updating the desktop file MIME type cache...
```

### Install Visual Studio Code

Command: `sudo pacman -S code`

- `sudo`: This command allows for administrative or "superuser" operations. It's necessary for tasks that require higher privileges than those granted to standard users.
- `pacman`: This is the package manager used by Manjaro and other Arch Linux-based distributions. It allows for installing, updating, and removing software on the system.
- `-S`: This option instructs pacman to install a package. `code` is the package name for Visual Studio Code.

Relevant Output:

- The system resolved dependencies and looked for conflicting packages.
- The system retrieved and installed the packages: `c-ares`, `electron22`, `jsoncpp`, `ripgrep`, `woff2`, and `code`.
- The total download size was 74.37 MiB, and the total installed size was 294.26 MiB.
- The system checked keys in the keyring, checked package integrity, loaded package files, checked for file conflicts, and checked available disk space.
- The system processed package changes and installed all the necessary packages.
- The system ran post-transaction hooks, including arming ConditionNeedsUpdate, refreshing PackageKit, and updating the desktop file MIME type cache.

The system has successfully installed Visual Studio Code.

## Loose ends

- None at this stage.

## Pending actions  / Next steps.

Great! Now that Visual Studio Code is installed, you can start using it for your development tasks. Here are some next steps you might consider:

1. **Explore Visual Studio Code**: Open the application and familiarize yourself with its interface. You can open files, navigate through your project's directory structure, and customize your workspace.

2. **Install Extensions**: Visual Studio Code has a rich ecosystem of extensions that can enhance your development experience. For example, if you're working with PHP, consider installing the PHP Intelephense extension for intelligent code completion and other advanced features.

3. **Configure Settings**: Visual Studio Code is highly customizable. You can adjust settings to suit your preferences and workflow. For instance, you can change the theme, modify the editor's behavior, and set up keybindings.

4. **Start Coding**: Now you're ready to start working on your project. You can create new files, write code, and use Visual Studio Code's built-in features to help you code more efficiently.

Remember, Visual Studio Code has a built-in terminal, source control management, and a debugger, making it a powerful tool for your development needs.

## Recommended Next Steps 

1. **Explore Visual Studio Code***
   - Task: Open the application

The Visual Studio Code has now been installed and is ready to explore.
