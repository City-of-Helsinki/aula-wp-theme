# Aula

This is WP-theme repo for Helsinki Aula-service. Aula is a student services, where students can find all relevant information within one view.

Page view is created by these elements:
- Header including logo, date&clock details and profile settings opener
- Search box (connected to Google or Duckduckgo)
- Services/Google integration box
- Link lifts

Features in the page are heavily linked with [Oppi school picker plugin](https://github.com/helkasko/oppi-school-picker). With the plugin functions, it's possible to detect the user by the school id. Example different services can be shown for peruskoulu-user or lukio-user.

## Services detection by "oppiaste"
As said above, different services are provided for different "oppiaste"-students. Services are created to WP custom post type `services`. 

Each service can be tagged with custom taxonomy `service-oppiaste`. With this custom taxonomy, we can show different services by user's "oppiaste". To this to work properly, taxonomy terms must be mapped, so that Oppi School Picer can detect terms correctly. This mapping in done in `Asetukset => Aulan asetukset => Oppiaste-asetukset`.

### Services functions
By default (if user has not done any customising), six services are shown. Rest can be viewed using the arrow button.
For services, user can do various things:
- each service can be set as default / remove as default
- user can also add custom links, these links are added to the end of non-default services-set. User can then move own service to default row, if wanted. All custom links are stored to separate db table `wp_user_own_services`.

As users can rearrange the services, custom api endpoint has been created to retrieve info by each service. This end point is in `/wp/v2/services`. TODO in 2025??!! It would be probably wise at some point optimise the customising features so that end point could be removed.

### Link lifts by user's school id
Link lifts in the bottom of the page uses user's school id along with Oppi School Picker helper functions to show link to school home page, link to "kouluruokailu", link to hobbies etc.

There is also possible to crate custom link lifts for each oppiaste. This is done in page settings.

### Info windows / "info ikkunat"
Info windows are a sticker feature that will appear on left side of the screen. Info windows are wp custom post type `info-popups`. Admins can add different info windows for users. Info windows will appear based on "oppiaste" similar in the way services are shown.

Functionality for info windows is basically custom javascript. See file `assets/scripts/routes/lib/infoWindow.js`.

### Concentrations / "Keskityymiset"
Concentrations are accessed via bottom left button (yoga person). These are handled as wp custom post type `concentration`. How added concentrations appear for user works the same way as services and info windows.

Functionality for concentrations is basically custom javascript. See file `assets/scripts/routes/lib/concentration.js`.

### Bottom left buttons
In the bottom left of the screen user can find different functions:
- concentration time:  user can set a timer (custom javascript)
- music (custom javascript)
- concentrations (see above)
- link to sanuli game
- current bg image details
- info button to access page info

### User settings
User can access user settings by clicking user icon in top right corner and choosing `Asetukset`.

In the settings user can:
- change current language
- hide different elements in page
- choose default search engine
- choose default school, if there are multiple school ids in user_data meta key
- choose a profile pic (empty or avatar), avatar functionality uses custom javascript with @multiavatar js-package

## About interactive functionality in the page
All interactive functionality, where user data is handled with server, is done with ajax.

See file `library/hooks/ajax-helpers.php` for all ajax functionality defined in theme.


## Server setup
`git clone` this repo in the root of the `wp-content/themes/`-folder. This will create you a theme folder `oppijaportaali`.

## Pull the latest code and settings

To get the latest stuff from this repo to server, execute `git pull origin master` in `wp-content/themes/oppijaportaali/`-folder.

After code is pulled, see from `WP-admin => Kenttäryhmät` if there is any fields to sync.

## Development installation (styles/scripts)

Current setup will work with node version defined in package.json along with Yarn. Yarn should be version 1.* (development done with yarn 1.22.4).

Local development domain should point to oppijaportaali.test, if you want to use `yarn start`.

Needed commands to work with:
`yarn install` ==> Install needed node packages
`yarn start` ==> start `Webpack` to watch & rebuild on asset changes in `localhost:3000`
`yarn prod` ==> Build for production: compresses the scripts & styles, disables sourcemaps, copies images from `assets/images` to `dist/images`


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

### Chat scripts
Depending on the user's school, different chat scripts are loaded to `<head>`. This is done using wp's `wp_head`-hook to set scripts based on user's school.

Logic for this is is done in `libarary/hooks/hooks.php` (look for `wp_head`). There is also helper file added, where the actual logic is: `library/hooks/apunappi-schools.pho`.


## Notable features 

## Version history

2.5 May 2025
- apunappi chat partialy published to certain schools

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
