So, we're at this point where we need a solid IDE to make our development process smoother. We could've gone with PHPStorm, it's familiar territory. But, considering the React learning curve and the open-source charm, Visual Studio Code seems like the way to go. Yes, it's a Microsoft product, but let's not hold that against it. We've got a plan in place - update the system packages and then install Visual Studio Code. We're yet to get started, but we'll keep you posted on the journey.
- Sat 05 Aug 2023 20:12:30 AEST


====

Sure, here's a summary of the guide from the Basiq API Quickstart Part 1:

1. **Register your application**: You need to register your application via the Basiq dashboard and configure your application before creating a new API key. You can create as many API keys as you want which allows you to use keys across different applications and environments. It's important to keep your API keys secret and not share them in publicly accessible areas.

2. **Authenticate**: Trade your new API key for an access token. The response will contain an access token which will allow you to make secure calls to the Basiq API. They expire every 60 minutes so it's recommended to store it globally and refresh 2-3 times an hour. For this quick start, the scope used is 'serveraccess'.

Here's a sample code snippet for authentication:

```javascript
var axios = require('axios');
var qs = require('qs');
var data = qs.stringify({ scope: 'serveraccess' });
var config = {
  method: 'post',
  url: 'https://au-api.basiq.io/token',
  headers: { 
    'Authorization': `Basic $yourapikey`, 
    'Content-Type': 'application/x-www-form-urlencoded',
    'basiq-version': '3.0'
  },
  data: data
};
axios(config)
.then(response => console.log(response.data))
.catch(error => console.log(error));
```

3. **Create a user**: Creating a user gives you a bucket to store all your financial data. Upon successful creation of a user, you will receive a user ID. With that and the access token you created earlier, you have everything you need to start creating and fetching financial data.

Here's a sample code snippet for creating a user:

```javascript
var axios = require('axios');
var data = JSON.stringify({ email: 'max@hooli.com', mobile: '+614xxxxxxxx' });
var config = {
  method: 'post',
  url: 'https://au-api.basiq.io/users',
  headers: { 
    'Authorization': `Bearer $youraccesstoken`,
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  },
  data: data
};
axios(config)
.then(function (response) {
  console.log(response.data);
})
.catch(function (error) {
  console.log(error);
});
```

After following these steps, you should have registered your application and made your first authenticated call to Basiq to create a user. 

Let me know if you need any further assistance!