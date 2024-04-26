# simple-view-generator
Generates a view as configured in a json file

## Features
### View Generator
To generate a view, create the template file in the templates folder then configure in pages.json file.
To configure pages.json, define the route as the property then fill in the values.
Importan note: The defined route is expected to have a slash. 
Example: 
This is correct  "/this-route"
This is wrong  "this-route"

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