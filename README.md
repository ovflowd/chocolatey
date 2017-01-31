![](http://www.habbcrazy.net/resources/fonts/116/chocolatey.gif)
<br><sup>chocolatey the Habbo.com Clone CMS</sup>

[![license](https://img.shields.io/github/license/mashape/apistatus.svg)]() [![Build Status](https://scrutinizer-ci.com/g/sant0ro/chocolatey/badges/build.png?b=development)](https://scrutinizer-ci.com/g/sant0ro/chocolatey/build-status/development) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sant0ro/chocolatey/badges/quality-score.png?b=development)](https://scrutinizer-ci.com/g/sant0ro/chocolatey/?branch=development)

The Open Source Habbo.com Clone CMS, it's fast, secure and with many features.

<hr>
### About

#### What is?

**Chocolatey** it's an open source content management system made with php. It uses Laravel's Lumen Micro Framework to handle all the API Requests and uses Habbo's Angular Module for rendering all views and requests.

#### What it uses?

1. php 7.0+ to implement it backend;
2. Laravel Lumen 5.4 to design it backend;
3. Angular 1.6.1 to design it frontend;
4. Eloquent ORM to handle & itterate with database;
5. Blade Template Engine to construct a dynamic template;
6. SQL to design the database schema;

#### For what i use Chocolatey?

For development purposes and to create test and educational local Habbo.com website (CMS) clones.

#### How i can have a full experience with Chocolatey?

* **Chocolatey** is totally compatible with [Arcturus Emulator](http://arcturus.wf), an open-source Habbo Emulator. **Chocolatey** only support it.
* Also **Chocolatey** only supports php 7.0+ environments, php 5.X is no longer supported.
* You can actually use **Chocolatey** in Apache HTTP Server 2.0+. For your security we recommend ModSecurity 2.

<hr>
### Installation
#### Installing a Production version of Chocolatey is really easy

1. Download the latest **Chocolatey** release
2. Extract it to your web-server <i>htdocs/public_html/wwwwroot/www</i> folder.
3. Configure your `.env` file with your Database Credentials
4. Edit `config/chocolatey.php` with some <i>optional</i> stuff. (Some fields are really required)
5. To finally migrate the Chocolatey Database. Open your <i>Terminal/CMD/Console</i> on the Chocolatey folder And execute the following command.: `php artisan migrate`. **If all Database credentials are right, Chocolatey** will successfully deploy his Database.
6. Open your Browser and be Happy.

<hr>
### Observations

#### Entering at Maintenance Mode
You can enter at the maintenance mode by opening your <i>Terminal/CMD/Console</i> on the Chocolatey folder and execute the following command.: `php artisan down`. This will enter the system in Maintenance Mode.

You actually can edit the white-list IP addresses by editing the `.env` file.

To get out from maintenance do the following command.: `php artisan up`.

#### Editing your Logo
Editing your Logo on **Chocolatey** it's a little more difficult. And because that we will release a Plugin that replaces the Habbo Logo by your logo on the Sprites file.
  
<hr>
### Collaborators
* Claudio aka saamus
* John aka Kylon
* Mike aka CineXMike

### Special Thanks
* Wesley aka The General
* Chris aka Leader (LeChris)
* Joorren because Joorren
* Cankiee aka Cankiee (loool)
* Martin aka Marit
