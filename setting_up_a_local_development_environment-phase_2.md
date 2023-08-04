# Project Report: Basiq API Integration for a Simple Web Application - Phase 2

## Project Overview

The project aims to integrate the Basiq API into a simple web application to retrieve account balance information for a specific savings account at a specific bank. The user is a PHP developer who is familiar with APIs but had difficulty understanding how to use the Basiq dashboard and API. The project is divided into two main phases:

1. **Phase 1:Basiq API Integration for a Simple Web Application**: This phase focused on understanding the Basiq API and Dashboard, providing a general overview of the Basiq API and Dashboard, addressing specific queries about the Basiq API and Dashboard, and providing a step-by-step guide for Basiq API integration. This phase also included setting up the necessary development environment with Docker and Lando.

2. **Phase 2: Setting Up the Local Development Environment**: This phase focuses on the actual implementation of the Basiq API into the user's web application. This includes setting up a local web server, implementing user authentication, retrieving account balance information, displaying account balance information, and error handling and testing.

We have completed Phase 1 and are currently in Phase 2 of the project.

## Executive Summary 

This phase of the project involves setting up a local development environment using Docker and Lando. The user has successfully installed Docker and Lando on their Manjaro Linux system. However, they encountered an issue with a missing libcrypt library when starting Lando. This issue has been resolved, but the user is now encountering a warning about an unsupported Docker version and a "Not Found" error when trying to access their site.

## Challenge Description 

The user encountered a missing libcrypt library issue with Lando, which prevented them from starting their local development environment. The user has now resolved this issue, but is encountering a warning about an unsupported Docker version and a "Not Found" error when trying to access their site.

## Initial Plan: 

5. **Install Docker for Lando Compatibility**
   - Status: Completed
6. **Install Lando**
   - Status: Completed
7. **Resolve Lando Startup Issue**
   - Status: Completed
8. **Set Up Development Environment**
   - Status: In Progress
9. **Create and Document .lando.yml File**
   - Status: Completed
10. **Write and Test a 'Hello World' PHP Script**
   - Status: Not Started

## Actions Taken 

4. Guided the user through the process of installing Docker on their Manjaro Linux system for compatibility with Lando.
5. Assisted the user in resolving a user account lockout issue.
6. Verified the successful installation of Docker by running a 'hello-world' Docker image.
7. Guided the user through the process of installing Lando manually from the GitHub releases page.
8. Assisted the user in troubleshooting a Lando startup issue.
9. Guided the user through the process of creating a .lando.yml file for their project.
10. Assisted the user in resolving a libcrypt library issue with Lando.
11. Guided the user through the process of starting Lando, addressing a warning about an unsupported Docker version, and troubleshooting a "Not Found" error when trying to access their site.

## Conclusion

The user has successfully installed Docker and Lando on their Manjaro Linux system, which are both necessary steps for the upcoming Web server setup. The user has resolved the libcrypt issue and has started Lando, but is encountering a warning about an unsupported Docker version and a "Not Found" error when trying to access their site. The next steps are to guide the user in creating a simple 'Hello World' PHP script to verify that their web server is working correctly, and to address the Docker version warning and "Not Found" error.

## Recommended Next Steps 

1. **Write and Test a 'Hello World' PHP Script**
   - Task: Assist the user in writing a simple 'Hello World' PHP script and testing it in their local development environment.
   - Status: Not Started
2. **Resolve Docker Version Warning**
   - Task: Investigate the Docker version warning and determine whether it's necessary to downgrade Docker to a version that Lando supports.
   - Status: Not Started
3. **Resolve 'Not Found' Error**
   - Task: Assist the user in resolving the "Not Found" error when trying to access their site.
   - Status: In Progress

**Previous Report:** [Understanding and Planning for Basiq API Integration](#understanding-and-planning-for-basiq-api-integration)
