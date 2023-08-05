# Setting up the Development Environment

## Executive Summary

This phase of the project involved setting up a local development environment using Docker and Lando. The user successfully installed Docker and Lando on their Manjaro Linux system. They encountered an issue with a missing libcrypt library when starting Lando, which has been resolved. However, they are now encountering a warning about the Docker version being incompatible with Lando. The Docker version installed was 24.0.2, while Lando supports Docker versions in the range of 18.09.3 - 20.10.99. And a "Not Found" error when trying to access their site. The user has also successfully created a 'Hello World' PHP script.

## Challenge Description 

The user encountered a missing libcrypt library issue with Lando, which prevented them from starting their local development environment. The user has now resolved this issue, but is encountering a warning about an unsupported Docker version and a "Not Found" error when trying to access their site. The next challenge was to downgrade Docker to a version compatible with Lando. This involved uninstalling the current Docker and Lando installations and then reinstalling a compatible Docker version.

## Initial plan: 

1. **Install Docker for Lando Compatibility**
    - Status: Completed
2. **Install Lando**
    - Status: Completed
3. **Resolve Lando Startup Issue**
    - Status: Completed
4. **Set Up Development Environment**
    - Status: In Progress
5. **Create and Document .lando.yml File**
    - Status: Completed
6. **Write and Test a 'Hello World' PHP Script**
    - Status: Completed
7. **Uninstall Lando**
    - Status: Completed successfully
8. **Uninstall Docker**
    - Status: Completed successfully
9. **Install a compatible Docker version**
    - Status: In progress
10. **Reinstall Lando**
    - Status: Pending

## Actions Taken 

1. Guided the user through the process of installing Docker on their Manjaro Linux system for compatibility with Lando.
2. Assisted the user in resolving a user account lockout issue.
3. Verified the successful installation of Docker by running a 'hello-world' Docker image.
4. Guided the user through the process of installing Lando manually from the GitHub releases page.
5. Assisted the user in troubleshooting a Lando startup issue.
6. Guided the user through the process of creating a .lando.yml file for their project.
7. Assisted the user in resolving a libcrypt library issue with Lando.
8. Guided the user through the process of starting Lando, addressing a warning about an unsupported Docker version, and troubleshooting a "Not Found" error when trying to access their site.
9. Assisted the user in creating a 'Hello World' PHP script.
10. Uninstalled Lando using the command `sudo pacman -R lando`.
11. Uninstalled Docker using the command `sudo pacman -R docker`.

## Pending actions

1. **Install a compatible Docker version.**
2. **Reinstall Lando.**
3. **Resolve 'Not Found' Error**
    - Task: Assist the user in resolving the "Not Found" error when trying to access their site.
4. **Clean Up Lando Pacman File**
    - Task: Guide the user to delete the Lando pacman file that was downloaded during the installation process.

## Loose ends

1. The Docker version needs to be downgraded to a version compatible with Lando. This is currently in progress.
2. Keeping Lando Updated
    Task: Provide advice to the user on how to keep Lando updated since it was installed from a file and not from a repository.

## Recommended Next Steps 

1. **Install a compatible Docker version**
   - Task: Use the Arch Linux Archive (ALA) or Docker's official convenience script to install a compatible Docker version.
   - Status: In progress
2. **Reinstall Lando**
   - Task: After installing a compatible Docker version, reinstall Lando using the command `sudo pacman -S lando`.
   - Status: Pending

## Conclusion 

The project is progressing well, with the current challenge being the Docker version incompatibility with Lando. The next steps involve installing a compatible Docker version and reinstalling Lando. The user has successfully installed Docker and Lando on their Manjaro Linux system, which are both necessary steps for the upcoming Web server setup. The user has resolved the libcrypt issue and has started Lando, but is encountering a warning about an unsupported Docker version and a "Not Found" error when trying to access their site. The next steps are to guide the user in resolving these issues, cleaning up the Lando pacman file, and providing advice on how to keep Lando updated.

Previous Report: Understanding and Planning for Basiq API Integration
