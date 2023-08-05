# Status: BasicVoyager - Implementing Basiq API into the Web Application

## Assignment name: BasiqVoyager

## Executive Summary 

The BasiqVoyager project aims to integrate the Basiq API into a web application. The project has gone through several phases, including researching available banking API services and tools, understanding the Basiq API and Dashboard, setting up the development environment, and configuring the Basiq API Dashboard and generating the API key. The project is currently in Phase 5, which involves implementing the Basiq API into the web application.

## Delayed by Rabbits

Before we can start coding properly, we need to get a few more tools setup.

We're at the starting line of getting Visual Studio Code up and running on the Manjaro system. We've got a two-step plan: first, we're going to update the system packages, then we'll dive into the installation. As of now, we're still at the 'on your marks' stage, with the actions yet to kick off. We've got a loose end to tie up - we need to confirm the repository URL and grab the 'rabbits' file. Once we've got that sorted, we're all set to get the ball rolling. You can read more about it in the [Visual Studio Code Rabbit document](rabbits/Visual_Studio_Code.md)

## Plan: 

1. **Phase 1 - Research available banking API services and tools**
   - Status: Completed
2. **Phase 2 - Understanding Basiq API and Dashboard**
   - Status: Completed
3. **Phase 3 - Setting up the Development Environment**
   - Status: Completed
4. **Phase 4 - Configuring Basiq API Dashboard and Generating API Key**
   - Status: Completed
5. **Phase 5 - Implementing Basiq API into the Web Application**
   - Status: In Progress

## Actions Taken 

| Action | Result | Feedback | Next Step |
| --- | --- | --- | --- |
| Research available banking API services and tools | Basiq API selected for integration | Positive | Understand Basiq API and Dashboard |
| Understand Basiq API and Dashboard | Gained knowledge about Basiq API and its dashboard | Positive | Set up the development environment |
| Set up the development environment | Environment set up successfully | Positive | Configure Basiq API Dashboard and generate API key |
| Configure Basiq API Dashboard and generate API key | API key generated successfully | Positive | Implement Basiq API into the web application |

## Loose ends

- Finalize the implementation of Basiq API into the web application
  - Test the API integration
  - Debug any issues

## Pending actions  / Next steps.

| Action | Expected Result |
| --- | --- |
| Implement Basiq API into the web application | Successful API integration |
| Test the API integration | Ensure the API is working as expected |
| Debug any issues | Ensure the application is running smoothly |

## Resources 

[Basiq Getting Quick Start - Part 1](https://api.basiq.io/docs/quickstart-part-1)

## Recommended Next Steps 

1. **Implement Basiq API into the Web Application**
   - Task: Code the API integration into the web application
2. **Test the API Integration**
   - Task: Run tests to ensure the API is working as expected
3. **Debug Any Issues**
   - Task: Fix any issues that arise during testing

The end goal of the project is to successfully integrate the Basiq API into a web application, providing a seamless banking experience. The most important action at this stage is to implement the Basiq API into the web application, and the next steps involve testing the API integration and debugging any issues.

==== New Event log since last report ===

We learned about the following concepts we read about on the Basiq getting started guide.

1. **Authentication Process**:
   When you want to use Basiq APIs, you need to authenticate your application first. The authentication process involves exchanging your API key for an access token. This token is like a special pass that allows your application to make secure calls to the Basiq API.

2. **Access Token**:
   Once you trade your API key for an access token, you receive the access token in the response. You should save this access token somewhere so that you can use it later to make API requests. The access token is like a ticket that allows your application to access the Basiq API securely. Keep in mind that access tokens have a limited lifespan, and they expire every 60 minutes. So, it's essential to keep track of the token's expiration time and refresh it when needed.

3. **Store it Globally**:
   Storing the access token "globally" means that you should keep it in a place that is accessible throughout your application, not tied to a specific user's session. A common approach is to store it in a configuration file or environment variable that can be accessed by different parts of your application.

4. **Scope**:
   In the context of Basiq API, "scope" refers to the level of access or permissions that your access token has. It determines what actions your application is allowed to perform. There are two types of scopes mentioned: `CLIENT_ACCESS` and `SERVER_ACCESS`.

5. **SERVER_ACCESS Scope**:
   The `SERVER_ACCESS` scope is more powerful and should be used for server-side requests. It grants full access to create resources and retrieve data from the Basiq API. It should never be exposed on the client side because it carries more privileges and could be a security risk if leaked.

6. **Client-Side Requests**:
   If you need to make requests from the client-side (e.g., in a web browser or mobile app), you should use the `CLIENT_ACCESS` scope, which is more restricted for security reasons. It allows access to specific requests like accessing the Consent UI and checking job status.

