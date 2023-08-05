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

Based on the content of the "Visual_Studio_Code.md" file from the repository, here's the "Actions Taken" section:

## Actions Taken

| Action | Steps | Feedback |
| --- | --- | --- |
| Update System Packages | 1. Open terminal<br>2. Run `sudo pacman -Syu` | - The system synchronized its package databases. The `core`, `extra`, `community`, and `multilib` databases are all up to date.<br>- The system started a full system upgrade. It found one package to upgrade: `brave-browser`. The `brave-browser` package was upgraded from version 1.56.19-1 to version 1.56.20-1.<br>- The system used Timeshift to create a snapshot before the upgrade.<br>- The system updated the GRUB bootloader with the new snapshot information. |
| Install Visual Studio Code | 1. Run `sudo pacman -S code` | - The system resolved dependencies and looked for conflicting packages.<br>- The system retrieved and installed the packages: `c-ares`, `electron22`, `jsoncpp`, `ripgrep`, `woff2`, and `code`. The total download size was 74.37 MiB, and the total installed size was 294.26 MiB.<br>- The system checked keys in the keyring, checked package integrity, loaded package files, checked for file conflicts, and checked available disk space.<br>- The system processed package changes and installed all the necessary packages.<br>- The system ran post-transaction hooks, including arming ConditionNeedsUpdate, refreshing PackageKit, and updating the desktop file MIME type cache. |
| Open Visual Studio Code | 1. Open the application | ## Actions Taken

## How to open Visual Studio Code

| Action | Result | Feedback |
| --- | --- | --- |
| Click on the Manjaro logo in the bottom left corner of the screen | KDE Application Launcher opens | The Application Launcher is similar to the Start Menu in Windows. It provides access to all the applications, directories, and settings on your computer. |
| Type 'code' into the search bar at the top of the Application Launcher | Visual Studio Code appears in the search results | The search function in the Application Launcher allows you to quickly find and open applications without having to navigate through menus. |
| Click on the Visual Studio Code icon | Visual Studio Code opens | This is the quickest way to open an application in KDE. |

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
