# Blog: BasiqVoyager - Configuring Basiq API Dashboard and Generating API Key

## Introduction

When it comes to exploring a new API, the journey is often filled with twists and turns. My recent experience with the Basiq API was no exception. In this post, I'll share my journey from creating an account to setting up a demo application, including all the roadblocks and decisions along the way.

In the world of APIs, getting started can often be the most challenging part. Today, we'll be walking through the process of setting up and configuring an application with the Basiq API. Basiq is a platform that provides a secure and simple way to connect with financial institutions, enabling you to retrieve user-consented financial data over a specified period of time. This data can be used to build financial services applications, perform affordability assessments, verify account details, and more.

## Starting Point: Account Creation

The journey began after I had created my Basiq account. The account creation process was straightforward, but the real challenge lay ahead: setting up an application and generating an API key.

## The First Roadblock: To create an application or not create an application, that is the question.

Actually the question is "Can I just use the existing Demo Application for my purposes here today?" and the answer is yes.

I logged into the Basiq dashboard and was immediately faced with a decision: should I create a new application or use the existing "Demo Application"?

### The Decision: Using the Demo Application

After weighing the options, I decided to use the "Demo Application". This decision was based on my goal of just wanting to get basic authenticated access to the Basiq API. Using the demo application seemed like the quickest way to achieve this.

## The Journey Begins: Creating an API key, well at least we should be.

https://dashboard.basiq.io/apiKeys

With the decision made, I proceeded to create an API key.

This is where I encountered the next redherring: setting permissions.

When I was presented with the "Create API Key" form, there is a text box to enter a label, and there is also a select box.
In that select box is a grey "not set" and a Blue "Manage Permissions" selection. I stinky brain ignored they grey "Not set" setting
and went straight to the blue one, which took me off the "Create API Key" into a permissions management area, with a log list of API endpoints that can be packaged
into a set and assigned a label, to be used to doing custom permissions. As a Drupal developer this reminds my of Drupal's permisions system.

However I was getting bogged down in trying to understand permissions and work out ones are the best choice for this project. I can consider assigning only the /account details permission, and I can considered assigning all of them for my testing. I realised this was way to complicated for "just get a connection to the API!", so I went back to the  "Create API Key" page and noticed the "Not set" option. I selected that and I got a little notice in red "This entity will have access to all service endpoints.".

For my purposes here, that's the setting I want. Moving on to creating the API key!

## The Journey begun a long time ago: Creating an API key, for real this time.

After some research and exploration, I discovered that I could select "Not set" for the permission set, which would give my API key access to all service endpoints. This was marked in red, probably because it's generally not a recommended practice for security reasons to give full access unless necessary. However, for my current purpose of just getting started and exploring the API, it seemed like the best option.

I just entered an API name BasiqVoyage which I have named my project, and selected "Not set". Then clicked continue. I then got a screen where I could copy the generated key, and some notes about keeping it safe.

I stored mine in a secure note in my private key store.

## The Roadblocks: Configuring Your Application

As we delve deeper into the configuration process, we encounter a few unexpected turns. The consent policy and institution selection options are not as straightforward as they initially seemed. 

The consent policy setup is hidden under the "Customise UI" option, which isn't immediately obvious. Here, we're able to customize the consent form, including the title, subtitle, and the data we'll collect. 

With the API key in hand, the next steps as we can tell from the documentation is to configure the demo application's "consent policy" and "available institutions".
This is documented to involve setting up details like `duration`, `title` & `subtitle`, `purposes`, `permissions`, and `supporting parties` for the `consent policy`, and selecting the `financial institution` where my account is held. Lol what?! I just want to connect to the dang API.

It's not wrong though, it's just not obvious at all how to do this or what it measn. This does involve setting up the application's consent policy and selecting the available institutions. 

Setting up the `consent policy` is a bit like navigating a maze. The act of "Customising the UI" and "Configureing the consent policy and selecting avilable insitutions" are one in the same. You configure what consent policies to present on your the form that is presented to the user of your application when giving their consent to you.
I won't go into the explicitly details of navigating the form editor. suffice it to say you can see two pages of the form side by side, you can click on elemenst on that form and change the title if you want, all the consent policies are selectable via that UI, but we will just accept the defaults. This is another thing we don't need to get distracted with for our purposes.

The page two of the form is where you encounter selecting the available institutions. This involves choosing from a list of institutions which ones we would like to present to our end users. I just selected my bank, keep it simple.

## The Destination: Making Authenticated Requests

After navigating through the twists and turns of the Basiq dashboard, we finally reach our destination. We've registered our application, generated an API key, set up our consent policy, and selected our institutions. We're now ready to start making authenticated requests to the Basiq API.


## The Journey Continues

As I continue to explore the Basiq API, I'm sure there will be more roadblocks and decisions to navigate. However, I'm also confident that with each challenge, I'll gain a deeper understanding of the API and how to use it effectively.

Our journey through the Basiq API setup process was not without its challenges. We encountered roadblocks, unexpected turns, and a few moments of confusion. However, with a bit of perseverance and exploration, we were able to successfully navigate the process and reach our destination.

If you're embarking on a similar journey with the Basiq API, remember that the journey is just as important as the destination. Each roadblock is an opportunity to learn, and each unexpected turn can lead to new discoveries. Happy coding!
