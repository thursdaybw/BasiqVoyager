# Status: BasiqVoyager - Consent UI Flow & Redirect URL Setup

## Objective:
To seamlessly integrate the Consent UI flow with the redirect URL, utilizing the token from Phase 7 to trigger user consent and validate the entire process in sandbox mode.

## Recommended Next Steps:

1. **Generate index.php for behind our redirect URL**
   - **Task**: Create the `index.php` file and set it up for the redirect URL.
   - **Expected Outcome**: A functional `index.php` file that's ready to handle the redirect URL.

2. **Use the token from Phase 7 to output a consent trigger**
   - **Task**: Integrate the token into `index.php` to trigger user consent.
   - **Expected Outcome**: Upon accessing the `index.php`, users should be prompted with a consent trigger, utilizing the token from Phase 7.

3. **Test the Consent UI Flow with Sandbox Mode**
   - **Task**: Use sandbox mode to test the entire flow, ensuring that the user can provide consent and the application can establish a connection to the financial institutions.
   - **Expected Outcome**: Successful testing in sandbox mode, confirming that the Consent UI flow works as expected and the application can connect to financial institutions post-consent.

## Milestones:
- Completion of `index.php` setup for redirect URL.
- Successful integration of the token from Phase 7 into `index.php`.
- Successful testing of the Consent UI flow in sandbox mode.

## Dependencies:
- Token generated from Phase 7.
- Basiq API documentation for any required configurations or adjustments.
- Access to sandbox mode for testing purposes.

## Risks:
- Potential issues with token integration.
- Unexpected behavior during sandbox testing.
- Possible changes or updates in the Basiq API that might affect the Consent UI flow.
