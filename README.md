# Server setup
`git clone` this repo in the root of the `wp-content/themes/`-folder. This will create you a theme folder `oppijaportaali`.

## Pull the latest code and settings

To get the latest stuff from this repo to server, execute `git pull origin master` in `wp-content/themes/oppijaportaali/`-folder.

After code is pulled, see from `WP-admin => Kenttäryhmät` if there is any fields to sync.

### Needed plugins to work properly:
- ACF Pro
  - This will create you settings to create page content
- Polylang
  - To support multilingual content
  
## SSO login and using the site from external networks

- Uses WPO 365 plugin
- Current settings:
 - When user logs out of Wordpress, they're also logged out of Azure. They're then returned to the FI front page
- The login button on the front page takes the user straight to Azure login
- When user tries to access the site from an external network, they're taken to the Azure login page

### What data is received via Azure and how to verify it?

Aula (WP site) will receive school abbrevation name and school grade via Azure.

To check that both school abbreavation name and grade is found for some user:
- check what is user's id (can be checked in WP-admin => Users ==> click on user ==> see id value from the address bar)
- Then in database run this command (in this example user's id is 1): `select meta_key, meta_value from wp_usermeta where user_id = 1 AND (meta_key = 'user_data' OR meta_key = 'user_grade')`

You should have result of two rows telling abbrevation name and grade of user.

If you don't see two rows, then integration to Azure is not ok.

## Session timeout

Include here info about session timeout...

## About Google Drive integration

Integration will be handled via app created in Google cloud console.

1. Go to the Google API Console.
2. Select an existing project from the projects list, or click NEW PROJECT to create a new project
- Type the Project Name.
- The project ID will be created automatically under the Project Name field. (Optional) You can change this project ID by the Edit link, but it should be unique worldwide.
- Click the CREATE button
3. Select the newly created project and enable the Google Drive API service.
- In the sidebar, select Library under the APIs & Services section.
- Search for the Google Drive API service in the API list and select Google Drive API.
- Click the ENABLE button to make the Google Drive API Library available.
4. In the sidebar, select Credentials under the APIs & Services section.
5. Select the OAuth consent screen tab, specify the consent screen settings.
- Enter the Application name.
- Choose a Support email.
- Specify the Authorized domains which will be allowed to authenticate using OAuth.
- Click the Save button.
6. Select the Credentials tab, click the Create credentials drop-down and select OAuth client ID.
- In the Application type section, select Web application.
- In the Authorized redirect URIs field, specify the redirect URL.
- Click the Create button.

A dialog box will appear with OAuth client details, note the Client ID and Client secret for later use. This Client ID and Client secret allow you to access the Google Drive API.

Note that: The Client ID and Client secret need to be specified at the time of the Google Drive API call. Also, the Authorized redirect URIs must be matched with the Redirect URL specified in the script.

### Adding support for Classroom API
In app settings you need to support Google ClassRoom API. Do the same as for Drive API:
- In the sidebar, select Library under the APIs & Services section.
- Search for the Google Classroom API service in the API list and select Google Classroom API.
- Click the ENABLE button to make the Google Classroom API Library available.

### Adding needed constants to wp-config.php

To have drive and classroom integration to work, add these lines to config:

```
define('GOOGLE_CLIENT_ID', 'YOUR_CLIENT_ID');
define('GOOGLE_CLIENT_SECRET', 'YOUR_CLIENT_SECRET');
define('GOOGLE_OAUTH_SCOPE', 'https://www.googleapis.com/auth/drive.metadata.readonly https://www.googleapis.com/auth/classroom.courses.readonly');
define('GOOGLE_REDIRECT_URI', 'YOUR_REDIRECT_URL');
define('OPENSSL_IV', 'random 16 letter string');
```

## Version history

2.4 Nov 2024
- added apunappi chat scripts
- added school selector in user settings, if user has two or more schools defined
- support for new department meta attribute to locate stadin AO users by office location
- some small fixes to remove php-notices

2.311 Jun 2024
- modify styles to target HKI city Thinkpad laptops

2.31 May 2024
- Remove support for O365 profile pic

Needs this SQL-query to be executed first:
```
UPDATE wp_usermeta
SET meta_value = 'use_empty'
WHERE meta_key = 'profile_picture_visibility' AND meta_value = 'use_o365';
```

2.3 Apr 2023
- Classroom integration

2.2 Mar 2023
- "mindfullness"-feature

2.1 Jan 2023
- Google Drive integration
- several smaller fixes and changes

2.0 - Sep 2022
- added timer for concentration
- added music playing
- added sanuli
- changed how services are sorted by default (by popularity)
- added Google as default search engine
- some ui changes

1.22 - May 2022
- added copyrights info about the bg image

1.21 - Feb 2022
- info windows now support more than one info window per time
- popupmenus now close automatically when clicked "outside"

1.2 - Jan 2022
- Info window statistics
- Info window color choices
- Info window remembers close button click (totally hide + turn grey)
- Service description is now shown when on hover (this feature is actually removed)
- Multiple smaller improvements and fixes
- Accessibility improvements

1.1 - Nov 2021
- Added PWA compatibility:
   - Android PWA created with Super Progressive Web Apps plugin
(https://superpwa.com/) that adds PWA compatibility to Android: Prompts to add the app to desktop, creaates desktop icon & creates a splash screen
   - IOS does not support PWA. Created custom modal to show only on IOS that prompts to add shortcut to home screen & created custom spash screen in all used IOS sizes
   - Added One Signal plugin (https://app.onesignal.com/) to ask permission & send push notifications for Android devices (disabled as of 01/2022)


1.0 - Dec 2020
- First version
  
## Development installation/usage

1. Clone the repo to WP `themes`-dir, rename the cloned dir, `cd` into and remove `.git`
2. Run `yarn` to install front-end-depencies
3. Run `yarn run config` to setup project
4. Change `package.json` config-section to suit your needs:
* `proxyUrl`: The default development URL where webpack will be proxied to
* `entries`: Scripts & styles which will be compiled to `/dist`-folder. Each entry will be compiled with the name specified with the objects `key`.

```json
"config": {
  "proxyUrl": "http://playground.test",
  "entries": {
    "main": [
      "./scripts/main.js",
      "./styles/main.scss"
    ],
    "customizer": [
      "./scripts/customizer.js"
    ],
    "admin": [
      "./admin/backend.js",
      "./admin/backend.scss"
    ]
  }
}
```

4. Run `yarn start` to start `Webpack` to watch & rebuild on asset changes
5. To build for production, run `yarn prod` which compresses the scripts & styles, disables sourcemaps, copies images from `assets/images` to `dist/images` and creates most common favicons automatically to `icons`-subfolder.


#### Available npm-scripts:
* `yarn start`: Start `webpack` to browsersync `localhost:3000`
* `yarn run prod`: Build assets for production
* `yarn test`: Test scripts
* `yarn run config`: Run project-config (On a fresh clone of this repo)


## Folder Structure

```
├── 1. assets
│   ├── admin
│   │   ├── backend.js
│   │   └── backend.scss
│   ├── dist
│   ├── fonts
│   ├── images
│   ├── scripts
│   │   ├── routes
│   │   └── util
│   │       └── main.js
│   ├── styles
│   │   ├── common
│   │   ├── components
│   │   ├── layouts
│   │   ├── vendor
│   │   └── main.scss
│   ├── webpack
│   │   └── development.js
│   │   └── plugins.js
│   │   └── production.js
│   │   └── webpack.base.js
|
├── 2. custom-templates
│   ├── template.tpl.php
|
├── 3. library
│   ├── acf-blocks
│   │   ├── blocks.php
│   ├── acf-data
│   ├── acf-options
│   ├── classes
│   │   ├── Bootstrap-navwalker.php
│   │   ├── Breadcrumbs.php
│   │   ├── CPT-base.php
│   │   ├── Initalization.php
│   │   └── Utils.php
│   ├── custom-posts
│   ├── functions
│   ├── hooks
│   ├── lang
│   └── widgets
|
├── 4. partials
│   ├── blocks
│   │   └── example-block.php
│   ├── components
│   ├── content-excerpt.php
│   ├── content-page.php
│   ├── content-search.php
│   ├── content-single.php
│   ├── content.php
│   ├── no-results-404.php
│   ├── no-results-search.php
│   └── no-results.php
|
├── 5. templates
├── .editorconfig
├── .eslintrc
├── .gitignore
├── .nvmrc
├── functions.php
├── index.php
├── package.json
├── README.md
├── screenshot
└── style.css
└── yarn.lock
```

**1. assets**
Place your images, styles & javascripts here (they get smushed and build to `assets/dist`-folder on WebPack `prod`). Javascripts will be compiled to `admin.min.js` (WP-admin-scripts), `customizer.min.js` (WP Customizer js) and `main.js.min` (the main js-file).

`styles`-dir is divided into smaller sections, each with it's responsibilities:
* `blocks`: Gutenberg block styling
* `common`: Global functions, settings, mixins & fonts
* `components`: Single components, e.g. buttons, breadcrumbs, paginations etc.
* `layouts`: General layouts for header, different pages, sidebar(s), footer etc.
* `vendor`: 3rd. party components etc. which are not installed through npm.

**2. custom-templates**
* Place your WordPress [custom-templates](https://developer.wordpress.org/themes/template-files-section/page-template-files/) here.

**3. library**
* `acf-blocks` / `acf-data` / `acf-options`: ACF block registering, using ACF JSON data and creating options
* `classes`: Holds the helper & utility-classes and is autorequired in `functions.php`
* `custom-posts`: Place your custom posts here. See example usage in `books.php.tpl`
* `functions`: The place for misc. helper functions
* `hooks`: The place for WP's `hooks`, `pre_get_posts` etc.
* `lang`: i18n for the theme
* `widgets`: WP-nav menus & widgets

**4. partials**
Partial files used by wrappers. Place additional partial components to `components`-folder

**5. templates**
WordPress required template-files
