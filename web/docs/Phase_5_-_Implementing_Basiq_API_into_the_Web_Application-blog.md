# Status: BasicVoyager - Implementing Basiq API into the Web Application

Before we start, we had some more work to do:

So, we're at this point where we need a solid IDE to make our development process smoother. We could've gone with PHPStorm, it's familiar territory. But, considering the React learning curve and the open-source charm, Visual Studio Code seems like the way to go. Yes, it's a Microsoft product, but let's not hold that against it. We've got a plan in place - update the system packages and then install Visual Studio Code. We're yet to get started, but we'll keep you posted on the journey.
- Sat 05 Aug 2023 20:12:30 AEST See: [Virtual Studio Code](rabbits/Virtual_Studio_Code.md)

---

Sure, here's a summary of the guide from the [Basiq API Quickstart Part 1](https://api.basiq.io/docs/quickstart-part-1)

1. **Have an API key**: We have an API key for the Demo Application

2. **Authenticate**: Trade your new API key for an access token. The response will contain an access token which will allow you to make secure calls to the Basiq API. They expire every 60 minutes so it's recommended to store it globally and refresh 2-3 times an hour. For this quick start, the scope used is 'serveraccess'.

Here's a sample code snippet for authentication:

```bash
curl --location --request POST 'https://au-api.basiq.io/token' \
  --header 'Authorization: Basic $YOUR_API_KEY' \
  --header 'Content-Type: application/x-www-form-urlencoded' \
  --header 'basiq-version: 2.0' \
  --data-urlencode 'scope=SERVER_ACCESS'
```

3. **Create a user**: Creating a user gives you a bucket to store all your financial data. Upon successful creation of a user, you will receive a user ID. With that and the access token you created earlier, you have everything you need to start creating and fetching financial data.

Here's a sample code snippet for creating a user:

```bash
curl --location --request POST 'https://au-api.basiq.io/users' \
  --header 'Authorization: Bearer $YOUR_ACCESS_TOKEN' \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/json' \
  --data-raw '{
    "email": "max@hooli.com",
    "mobile": "+614xxxxxxxx"
  }'
```

We need to turn this into PHP code. I have tried this and am having some issues.
