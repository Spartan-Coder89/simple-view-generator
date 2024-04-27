# simple-view-generator
A php application to generate pages to create a php website.

## Basic configuration
Basic configuration is done in config.json. You can add your own then it is accessable sitewide with the CONFIG array constant. <br>
**Importan note:** site_url, public_uri, and session_requirement config are defaults. Removing them will break the application. <br>

```json
{
  "site_url" : "https://yoursiteurl.com",
  "public_uri" : "https://yoursiteurl/public",
  "session_requirement" : []
}
```

### Ready made global constants
* ROOT_DIR - returns the root directory of site
* PUBLIC_URI - returns the absolute url of the public directory

### Ready made global functions
* get_site_url() - returns the site url
* get_partial_template( 'partial.php' ) - to include a partial into a template. Needs only the partial file name created in templates/partials. **Should include the file extension.**

## Features
### View Generator
To generate a view, create your html php template file in the templates folder then configure in pages.json file.
To configure pages.json, define the route as the property then fill in the values. <br>
**Importan note:** The defined route is expected to have a slash. <br>
**Example:** <br>
This is correct  **"/this-route"** <br>
This is wrong  **"this-route"**

```json
{
  "/" : {
    "template_file" : "front.php",
    "view_title" : "Frontpage",
    "page_id" : "front",
    "styles_enqueue" : [
      "common.css"
    ],
    "script_enqueue" : [
      "common.js|footer"
    ],
    "language" : "en",
    "meta" : [
      {
        "charset" : "UTF-8"
      },
      {
        "name" : "viewport",
        "content" : "width=device-width, initial-scale=1.0"
      },
      {
        "name" : "description",
        "content" : "Front page of this website"
      },
      {
        "name" : "robots",
        "content" : "index, follow"
      }
    ],
    "favicon" : "",
    "apple_touch_icon" : ""
  },
  "/login" : {
    "template_file" : "login.php",
    "view_title" : "Login",
    "page_id" : "login",
    "styles_enqueue" : [
      "common.css"
    ],
    "script_enqueue" : [
      "common.js|footer"
    ],
    "language" : "en",
    "meta" : [
      {
        "charset" : "UTF-8"
      },
      {
        "name" : "viewport",
        "content" : "width=device-width, initial-scale=1.0"
      },
      {
        "name" : "description",
        "content" : "Front page of this website"
      },
      {
        "name" : "robots",
        "content" : "index, follow"
      }
    ],
    "favicon" : "",
    "apple_touch_icon" : ""
  }
}
```

### Rest Endpoints
To create rest endpoints, define your endpoint in rest.json file then create the callback file inside the rest folder. <br>
**Importan note:** The defined endpoint is expected to have a slash. <br>
**Example:** <br>
This is correct  **"/this-route"** <br>
This is wrong  **"this-route"**

```json
{
  "/test-route" : {
    "method" : "GET",
    "callback_file" : "test_route.php"
  }
}
```

### Session requirements
To define if a page needs a session, just add the page route in the session requirement config. By default everytime a page is loaded a session is started. A session variable of user_id is used to define if is in session. Should not be empty, null or undefined to be in session.

```json
{
  "site_url" : "https://yoursiteurl.com",
  "public_uri" : "https://yoursiteurl/public",
  "session_requirement" : ["/page-route", "/another-page-route"]
}
```

### Security
For XSS <br>
- You can generate a token and verify using <br>
```
Auth::generate_nonce()
Auth::verify_nonce( 'Token goes here' )
```