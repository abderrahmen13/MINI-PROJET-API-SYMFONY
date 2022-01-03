1. The Firewall :
    The firewalls section of config/packages/security.yaml is the most important section. A "firewall" is your authentication system: the firewall defines which parts of your application are secured and how your users will be able to authenticate (e.g. login form, API token, etc).
2. Authenticating Users :
    - Hashing Passwords
    - jwt
    - json_login
    - login_throttling
3. cookie_lifetime :
    The cookie_lifetime setting is the number of seconds the cookie should live for
4. Access Control (Authorization) :
    - Roles