# BasiqVoyager - Phase 8 - Deep Dive into Basiq API Questions Answered

## Introduction

In this phase of our journey with the Basiq API, we took a deep dive into the documentation and addressed some burning questions. As always, the goal is to provide clarity and ensure that we're making the most of the tools at our disposal.

## The Basics

1. **What is the Basiq API?**
   - Basiq API is a platform that allows developers to connect with users' bank accounts. It provides access to transaction data, which can be used for various purposes, such as financial management, insights, and more.

2. **How does the Basiq API work?**
   - The Basiq API works by establishing a secure connection between your application and the user's bank. Once the user provides consent, the API retrieves the necessary data.

3. **What is an Access Token**: This is the token you generate using `generate_and_output_token.php`. It's used to authenticate your application's requests to the Basiq API. This token typically has a short lifespan (like 1 hour, as you mentioned). You use this token to perform operations like creating a user or fetching data.

4. **What is a User-specific Token**: Once you've created a user via the Basiq API, you can generate a user-specific token (or client token bound to the user). This token is used to initiate the consent process. It ties the consent process specifically to the user you've created.

## A deeper dive

1. **Your access token**
   - Identifies your application to Basiq and is used for all your API interactions.
  
2. **User-specific Token for Consent**:
   - Yes, the user-specific token (often referred to as a "client token bound to the user") is typically short-lived. Its primary purpose is to initiate the consent process for a specific user. Once the consent process is complete, this token has served its purpose and is no longer needed for subsequent API calls.

3. **Identifying Your Application**:
   - When you registered your application with Basiq, you would have been provided with credentials (like an API key or client ID/secret). These credentials uniquely identify your application to Basiq.
   - When you generate the access token using `generate_and_output_token.php`, you're authenticating with these credentials. This means that any token generated is tied to your specific application.

4. **The identifier**
   - On the incoming URL after the redirection (if provided) can be used for various purposes, such as confirming the completion of the consent process in your application's logic or for tracking purposes. However, it's not mandatory for fetching the user's data.

6. **Consent Process & Redirection**:
   - When the user is redirected to Basiq's Consent UI using the user-specific token, Basiq knows which user is giving consent because of that token.
   - After the user gives consent on Basiq's UI, they are redirected back to your application. As part of this redirection, Basiq typically includes some form of identifier in the URL (like a query parameter). This could be a confirmation code, a temporary token, or another artifact.
   - Your application needs to capture this identifier from the redirected URL. This identifier is proof that the user has given consent. You'll use it (along with your access token) to fetch the user's data from the Basiq API.

7. **Consent Process & Redirection**:
   - When the user completes the consent process on Basiq's UI, they are redirected back to your application. As part of this redirection, Basiq may include an identifier in the URL (like a query parameter). This identifier is optionally available to serve as a confirmation that the user has completed the consent process which you can use in you client (browser) to respond to the consent stastus or error on client side.
   - 
8. **Fetching Data with Consent**:
   - When you make an API call to fetch the user's data, you'll primarily use your access token for authentication. This access token identifies your application to Basiq.
   - Basiq knows which user has given consent based on the user-specific token used during the consent initiation. However, the identifier from the redirection (if provided) can serve as an additional confirmation or for other purposes in your application logic.

In essence, the primary token you need for fetching the user's data is your access token. The user-specific token and the identifier from the redirection play roles in the consent process and can be used for additional logic or tracking in your application.

## The Implentation
   
### Initiation: Your Web Page

You'll start by having a trigger on your web page or CLI script. This could be a button labeled something like "Connect to Bank" or "Link Bank Account". If you're using a web interface, this is typically a button on your web page.

The initiation step is where you provide the user with an option to start the process of linking their bank account. Depending on your setup (web interface or CLI), the implementation can vary.

For our purposes we will have generated a user token via our PHP script, and user PHP to pass the token to the pages, so we can redirect to submit to it.

#### Steps to Get User's Consent:

#### 1. **Generate User-specific Token**:
   - After creating a user using your access token, you'll need to generate a user-specific token for the consent process. This might involve another API from PHP to call to Basiq where you pass in the user ID and receive a token specific to that user. This is the token you inject into the "Web Page Implementation" coming up.

#### 2. **Web Page Implementation**:

##### Initiate Consent Process**:
   - Use the user-specific token to redirect the user to Basiq's Consent UI. This ensures that the consent given is specifically tied to the user you've created.

- **Form Submission**:
  
   ```php
   <?php
   $userSpecificToken = get_short_lived_user_specific_token_from_basiq_api();
   ?>

   <form action="https://consent.basiq.io/home" method="get">
       <input type="hidden" name="token" value="<?php echo $userSpecificToken; ?>">
       <input type="submit" value="Connect to Bank">
   </form>
   ```

- **Button with JavaScript**:
  - You can have a simple button on your web page. When this button is clicked, a JavaScript function is triggered.
  - This JavaScript function will redirect the user to Basiq's Consent UI.
  
  ```html
  <button onclick="redirectToBasiqConsent()">Connect to Bank</button>
  
  <script>
  function redirectToBasiqConsent() {
      // Inject the user token via PHP and replace YOUR_CLIENT_TOKEN with it.
      var clientTokenBoundToUserId = "<?php get_short_lived_user_specific_token_from_basiq_api() ?>"; 
      window.location.href = `https://consent.basiq.io/home?token=${clientTokenBoundToUserId}`;
  }
  </script>
  ```

The key is to redirect the user to the Basiq Consent UI with the appropriate token. Whether you use JavaScript, a form submission, depends on your application's setup and your users' interaction mode.

##### Redirect to Basiq's Consent UI
   - **User Action**: Once the user clicks on this button, they are redirected to Basiq's Consent UI.
   - **Behind the Scenes**: This redirection is achieved by setting the window's location to Basiq's Consent URL with a specific token bound to the user ID. The URL would look something like this: `https://consent.basiq.io/home?token=clientTokenBoundToUserId`.

##### User Gives Consent
   - The user will interact with Basiq's Consent UI, select their bank, provide credentials, and grant consent.

##### **User Interaction with Basiq's Consent UI
   - **Consent Page**: On this page, the user will see a list of financial institutions. They'll select their bank and proceed.
   - **Authentication**: The user will then be prompted to enter their online banking credentials. This is a secure process, and Basiq ensures that user data is handled with utmost privacy.
   - **Granting Consent**: After successful authentication, the user will be shown a summary of the data that your application is requesting access to (e.g., account details, transaction history). They'll have the option to grant or deny this access.

##### Completion and Redirection
   - **Consent Granted**: If the user grants consent, Basiq will create a link between the user's access token and your applications.
   - **Redirection**: After this, the user will be redirected back to a callback URL you've specified in your application settings. This is where you handle the next steps in your application logic.
   - **Receiving Data**: Along with the redirection, Basiq may send back a token or some form of identifier. You'll use this to make subsequent API calls to fetch the user's data.
   
4. **Retrieve Data**:
   - Once consent is given, you can use your access token in PHP to fetch the user's data from the Basiq API.


## Conclusion

Our exploration of the Basiq API was enlightening. By addressing each question in detail, we've gained a deeper understanding of the platform and its capabilities. As we continue our journey, we'll be better equipped to harness the power of the Basiq API for our financial applications.

---




========================





### Step-by-Step User Consent Process:

1. **Initiation**:
   - **Your Web Page/CLI**: You'll start by having a trigger on your web page or CLI script. This could be a button labeled something like "Connect to Bank" or "Link Bank Account". If you're using a web interface, this is typically a button on your web page.

2. **Redirect to Basiq's Consent UI**:
   - **User Action**: Once the user clicks on this button, they are redirected to Basiq's Consent UI.
   - **Behind the Scenes**: This redirection is achieved by setting the window's location to Basiq's Consent URL with a specific token bound to the user ID. The URL would look something like this: `https://consent.basiq.io/home?token=clientTokenBoundToUserId`.

3. **User Interaction with Basiq's Consent UI**:
   - **Consent Page**: On this page, the user will see a list of financial institutions. They'll select their bank and proceed.
   - **Authentication**: The user will then be prompted to enter their online banking credentials. This is a secure process, and Basiq ensures that user data is handled with utmost privacy.
   - **Granting Consent**: After successful authentication, the user will be shown a summary of the data that your application is requesting access to (e.g., account details, transaction history). They'll have the option to grant or deny this access.

4. **Completion and Redirection**:
   - **Consent Granted**: If the user grants consent, Basiq will create a connection between your application and the user's bank.
   - **Redirection**: After this, the user will be redirected back to a callback URL you've specified in your application settings. This is where you handle the next steps in your application logic.
   - **Receiving Data**: Along with the redirection, Basiq will send back a token or some form of identifier. You'll use this to make subsequent API calls to fetch the user's data.

5. **Fetching Aggregated Data**:
   - **API Calls**: With the received token or identifier, you can now make API calls to Basiq to fetch the user's aggregated data, such as account details or transaction history.




In summary, the token you generated with `generate_and_output_token.php` is your access token for general API interactions. For the consent process, you'll need a user-specific token that ties the consent to the specific user you've created.

Hope that clears things up! If you need more details or have other questions, just give me a shout. Cheers! 🍻
