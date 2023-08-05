# Blog Post: Basiq API Integration for a Simple Web Application - The Journey So Far

## Overview

The journey of integrating the Basiq API into a simple web application has been an exciting one, filled with learning, challenges, and a few unexpected turns. As a PHP developer familiar with APIs, I embarked on this journey with the aim of retrieving account balance information for a specific savings account at a specific bank. The project was divided into two main phases: understanding and planning for Basiq API integration, and setting up the local development environment. 

## Researching for a Relevant API Service

The first step in this journey was to find a suitable API service that could provide the necessary account balance information. After some research, I settled on the Basiq API. Basiq is a platform that provides a secure and simple way to connect with financial data. Their API seemed to offer exactly what I needed for my web application.

## Learning About Basiq API

The next step was to understand how to use the Basiq API and Dashboard. This was a bit of a challenge at first, as the Basiq Dashboard and API were new to me. However, with some time and effort, I was able to get a good grasp of how to use them. I learned how to make API requests, handle responses, and navigate the Basiq Dashboard. This knowledge was crucial for the next phase of the project.

## Setting Up the Local Development Environment

With a good understanding of the Basiq API, I moved on to setting up the local development environment. This involved installing Docker and Lando on my Manjaro Linux system. Docker is a platform that allows you to automate the deployment, scaling, and management of applications, while Lando is a free, open-source, and cross-platform local development environment.

## Overcoming Challenges

Setting up the local development environment was not without its challenges. I encountered an issue with a missing libcrypt library when starting Lando. This issue prevented me from starting my local development environment. However, with some assistance, I was able to resolve this issue by installing the missing library.

## The Unexpected Tangents

During the process of setting up the local development environment, I encountered a warning about the Docker version being incompatible with Lando. The Docker version installed was 24.0.2, while Lando supports Docker versions in the range of 18.09.3 - 20.10.99. This led me down an unexpected path of attempting to downgrade Docker to a version compatible with Lando.

## Attempting to Downgrade Docker

Downgrading Docker proved to be a challenge. The package manager in Manjaro does not support installing specific versions of a package. I tried using the downgrade utility, setting environment variables, and even considering manually installing Docker. However, none of these attempts were successful.

## Backtracking and Looking Ahead

After several attempts to downgrade Docker, I decided to put this issue aside for the time being. I backtracked and tested if Lando would work with the newer Docker version, despite the compatibility warning. If Lando works as expected, I can continue using the current setup. If not, I will need to find another solution for the Docker version compatibility issue.

The journey so far has been a mix of learning, overcoming challenges, and dealing with unexpected turns. However, each step, each challenge, and each tangent has been a stepping stone towards my goal. As I look ahead, I am excited to continue this journey, to implement the Basiq API into my web application, and to share my experiences along the way. Stay tuned for more updates as I continue to navigate this journey.
