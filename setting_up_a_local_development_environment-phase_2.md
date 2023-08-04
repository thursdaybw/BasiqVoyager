# Project Report: Basiq API Integration for a Simple Web Application - Phase 2


## Project Overview

The project aims to integrate the Basiq API into a simple web application to retrieve account balance information for a specific savings account at a specific bank. The user is a PHP developer who is familiar with APIs but had difficulty understanding how to use the Basiq dashboard and API. The project is divided into two main phases:

### Phase 1 - Basiq API Integration for a Simple Web Application

This phase focused on understanding the Basiq API and Dashboard, providing a general overview of the Basiq API and Dashboard, addressing specific queries about the Basiq API and Dashboard, and providing a step-by-step guide for Basiq API integration. This phase also included setting up the necessary development environment with Docker and Lando.

### Phase 2 - Setting Up the Local Development Environment

This phase focuses on the actual implementation of the Basiq API into the user's web application. This includes setting up a local web server, implementing user authentication, retrieving account balance information, displaying account balance information, and error handling and testing.

We have completed **Phase 1** and are currently in **Phase 2** of the project.

## Executive Summary 

This phase of the project involved setting up a local development environment using Docker and Lando. The user successfully installed Docker and Lando on their Manjaro Linux system. They encountered an issue with a missing libcrypt library when starting Lando, which has been resolved. However, they are now encountering a warning about an unsupported Docker version and a "Not Found" error when trying to access their site. The user has also successfully created a 'Hello World' PHP script.

## Challenge Description 

The user encountered a missing libcrypt library issue with Lando, which prevented them from starting their local development environment. The user has now resolved this issue, but is encountering a warning about an unsupported Docker version and a "Not Found" error when trying to access their site.

## Initial Plan: 

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

## Pending actions

1. **Resolve Docker Version Warning**
   - Task: Investigate the Docker version warning and determine whether it's necessary to downgrade Docker to a version that Lando supports.
2. **Resolve 'Not Found' Error**
   - Task: Assist the user in resolving the "Not Found" error when trying to access their site.
3. **Clean Up Lando Pacman File**
   - Task: Guide the user to delete the Lando pacman file that was downloaded during the installation process.

## Loose ends

1. **Keeping Lando Updated**
   - Task: Provide advice to the user on how to keep Lando updated since it was installed from a file and not from a repository.

## Recommended Next Steps 

1. **Resolve Docker Version Warning**
   - Task: Investigate the Docker version warning and determine whether it's necessary to downgrade Docker to a version that Lando supports.
   - Status: Not Started
2. **Resolve 'Not Found' Error**
   - Task: Assist the user in resolving the "Not Found" error when trying to access their site.
   - Status: In Progress
3. **Clean Up Lando Pacman File**
   - Task: Guide the user to delete the Lando pacman file that was downloaded during the installation process.
   - Status: Not Started
4. **Keeping Lando Updated**
   - Task: Provide advice to the user on how to keep Lando updated since it was installed from a file and not from a repository.
   - Status: Not Started

## Conclusion 

The user has successfully installed Docker and Lando on their Manjaro Linux system, which are both necessary steps for the upcoming Web server setup. The user has resolved the libcrypt issue and has started Lando, but is encountering a warning about an unsupported Docker version and a "Not Found" error when trying to access their site. The next steps are to guide the user in resolving these issues, cleaning up the Lando pacman file, and providing advice on how to keep Lando updated.

Previous Report: Understanding and Planning for Basiq API Integration
