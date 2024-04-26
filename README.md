# simple-view-generator
Generates a view as configured in a json file

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

## Features
### View Generator
To generate a view, create the template file in the templates folder then configure in pages.json file.
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