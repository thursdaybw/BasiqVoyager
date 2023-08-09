# Assignment name: Understanding Basiq API and Open Banking Access Requirements

## Executive Summary 

We have been investigating the requirements for accessing Open Banking data via the Basiq API. Our findings indicate that depending on the chosen access model, it may be necessary to apply for accreditation with the Australian Competition and Consumer Commission (ACCC) as an Accredited Data Recipient (ADR). However, some access models may not require official Consumer Data Right (CDR) accreditation. We also strongly suspect, based on the response from a Basiq representative, that Basiq may require ACCC accreditation even for accessing data via web scraping, despite this not being a strict legal requirement under the CDR.

## Plan: 

1. **Understand Access Models**
   - Status: Completed
2. **Identify Accreditation Requirements**
   - Status: Completed
3. **Clarify Role of Principal and Outsourced Service Provider**
   - Status: Completed

## Actions Taken 

| Action | Result | Feedback | Next Step |
| --- | --- | --- | --- |
| Researched Basiq API documentation | Identified various access models | Access models include ADR, Sponsored Affiliate, Principal Representative, Trusted Advisor, CDR Insights, and Outsourced Service Provider | Understand specific requirements for each model |
| Searched for ACCC accreditation process | Found that accreditation may be required for some access models | ACCC accreditation process can be lengthy and involves meeting stringent compliance requirements | Determine if accreditation is necessary for specific use case |
| Clarified role of principal and outsourced service provider | Principal typically refers to the ADR, Outsourced Service Provider works on behalf of the principal | Outsourced Service Provider model implies a relationship with an ADR | Determine if a relationship with an ADR is feasible or necessary |

## Loose ends

- Need to confirm with Basiq or a legal expert about the exact requirements for the specific use case.
- Need to clarify if the sandbox environment can connect to a real bank.
- Clarify if Basiq is just an Accreditated Data Receiver(ADR), then perhaps they can treat this app as an "Outsourced Service Provider"?
- Maybe I should register an ABN.

## Pending actions / Next steps.

| Action | Expected Outcome |
| --- | --- |
| Reach out to Basiq for guidance | Get accurate and up-to-date information based on the specific use case |
| Consult with a legal expert | Understand the legal implications of the chosen access model |

## Recommended Next Steps 

1. **Reach out to Basiq**
   - Task: Get accurate and up-to-date information based on the specific use case
2. **Consult with a legal expert**
   - Task: Understand the legal implications of the chosen access model

## FAQ 

1. **What is the Consumer Data Right (CDR)?**
   - The Consumer Data Right (CDR) is a legal right in Australia that allows consumers
to access their data from businesses and share it with accredited service providers. 
In the context of Open Banking, this means that banks and other financial institutions are
required to provide access to their data via APIs.
   - Basiq acts as a single entry point to access data from all supported financial instituions to provide a single unified consistant interface.   

     1a. **Can I apply for Open Data access directly with my financial institution?**
       - Potentially, however if this app takes off or even if I change banks, I would have to do at least a little if not a massive rebuild of my app. This is the benefit of Basiq.  
       - Assumption: Basiq has some special kind of accreditation (or may just be an Accreditated Data Recipient) that got in early and positioned themselves.

2. **What is 'Open Banking'?**
   - Open Banking is a system where banks and other financial institutions provide access to their data via Application Programming Interfaces (APIs). This allows third-party developers, such as Basiq, to build applications and services around the financial institution. Open Banking is part of the Consumer Data Right in Australia, aiming to give consumers more control over their financial data.

3. **What is Basiq?**
   - Basiq is an accredited entity that provides a secure and simple way to connect with financial data. They offer APIs that allow developers to access financial data from a variety of sources, including banks and other financial institutions. Basiq is used for a range of applications, from personal finance management apps to lending platforms and more. They connect to Open Banking APIs provided by banks under the Consumer Data Right, given they have the necessary authorisation.

4. **Does the financial institution that holds my acccount offer an Open Banking API at this time?**
   - No, the financial institution that holds my account does not currently offer an Open Banking API.
   - I have not found any information about direct access to an Open Banking API for my instition.
   - I noticed on the configuration inside basiq for that instition is marked as "web".
   - Open Banking is relatively new and my suspsicion is that the financial institions are dragging their feet in getting it implemented.

5. **How does Basiq retrieve the data from my financial institution?**
   - Basiq can retrieve my account data from my financial institution through web scraping. I have researched my financial instition as my very first step on this journey and that eventually lead me here to Basiq.

  5a. **Doesn't the fact they it's scraped mean it's not CDR and technically I do not need to meet the CDR?**
    - Technically yes, my very strong suspician is that Basiq requires it anyway, I would.

6. **What is an Accredited Data Recipient (ADR)?**
   - An ADR is an entity that has been granted accreditation by the ACCC to receive CDR data.

7. **What is the role of an Outsourced Service Provider?**
   - An Outsourced Service Provider is an entity that collects CDR data from a CDR participant on behalf of the principal (the ADR), or provides goods or services to the principal using CDR data.
   - In order to qualify my "app" as an "Outsourced Service Provider" I would need to be sponsored by and "ADR".

8. **Do I need to apply for ACCC accreditation to access Open Banking data via Basiq?**
   - Depending on the access model I choose, I may need to apply for accreditation with the ACCC. Some access models, such as the "Trusted Advisor" or "Outsourced Service Provider" models, may not require official CDR accreditation.

9. **Can I connect to a real bank in the sandbox environment?**
   - The sandbox environment is typically used for testing with simulated data, not real data. For accessing real bank data, I'd generally use a production environment.

10. **Can Basiq enable the sandbox to talk to a real bank, or can they approve a production application?**
   - I contacted a Basiq representative via the discussion board of the representative's Basiq GitHub account, seeking clarification about access to production data. The Basiq representative's response was: 

     > "The 'Error: Connections not enabled - Error: Access denied' relates with live connection, on sandbox environment, you can use our test institutions which are [outlined here](https://basiq.io/docs/guide/connections#test-institutions) in our docs, but if you try to connect with a real bank account, you will get this error, In this case, Basiq enables this for you, all you need to do is to reach out to support@basiq.io and discuss your plan."

     The use of the word "this" in the representative's response creates ambiguity. It could be interpreted as Basiq being able to enable a live connection to a real bank in the sandbox environment. However, this interpretation seems implausible as the term "sandbox" typically implies a testing environment without access to production data. Alternatively, the representative might be using "this" to refer to a shift in context, implying that Basiq can enable a live connection to a real bank in a production environment. Given the ambiguity, it would be best to seek further clarification directly from Basiq support.
