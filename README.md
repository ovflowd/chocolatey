![](http://www.habbcrazy.net/resources/fonts/116/chocolatey.gif)
<br><sup>chocolatey the Habbo.com Clone CMS</sup>

<hr>
### Being Developed with love in Lumen

<hr>
### This CMS works only with Arcturus
#### Get Arcturus today by accessing http://arcturus.wf

<hr>
### Installation
#### Installing a Production version of Chocolatey is really easy

1. Download the latest <b>Chocolatey</b> release
2. Extract it to your web-server <i>htdocs/public_html/wwwwroot/www</i> folder.
3. Configure your `.env` file with your Database Credentials
4. Edit `config/chocolatey.php` with some <i>optional</i> stuff. (Some fields are really required)
5. To finally migrate the Chocolatey Database. Open your <i>Terminal/CMD/Console</i> on the Chocolatey folder And execute the following command.: `php artisan migrate`. <b>If all Database credentials are right, Chocolatey</b> will successfully deploy his Database.
6. Open your Browser and be Happy.

<hr>
### Observations
#### Entering at Maintenance Mode
You can enter at the maintenance mode by opening your <i>Terminal/CMD/Console</i> on the Chocolatey folder and execute the following command.: `php artisan down`. This will enter the system in Maintenance Mode.

You actually can edit the white-list IP addresses by editing the `.env` file.

To get out from maintenance do the following command.: `php artisan up`.

#### Editing your Logo
Editing your Logo on Chocolatey it's a little more difficult. And because that we will release a Plugin that replaces the Habbo Logo by your logo on the Sprites file.
  
<hr>
### Collaborators
* Claudio aka saamus
* John aka Kylon
* Mike aka CineXMike

### Special Thanks
1. Wesley aka The General
2. Chris aka Leader (LeChris)
3. Joorren because Joorren
4. Cankiee aka Cankiee (loool)
5. Martin aka Marit
