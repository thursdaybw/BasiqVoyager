# Assignment name: Visual Studio Code Installation

## Executive Summary 

As part of our ongoing project, we've identified the need for a robust IDE to facilitate the development process. The decision has been made to install Visual Studio Code on the Manjaro system. This document outlines the steps taken and the plan for this installation.

As part of the preparation for installing Visual Studio Code on the Manjaro system, we performed a system update using the pacman package manager. This document outlines the steps taken and the results of this update.

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

## Loose ends

- None at this stage.

## Pending actions  / Next steps.

- Install Visual Studio Code

## Recommended Next Steps 

1. **Install Visual Studio Code**
   - Task: Run `sudo pacman -S code` in the terminal.

The system is now up-to-date and ready for the installation of Visual Studio Code.
