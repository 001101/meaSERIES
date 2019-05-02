# Installation

Before proceeding with the installation you will need:

* a WEB server with PHP (local or distant) where you can install meaSERIES.
* at least one premium subscription to Uptobox or 1fichier services (but ideally both).

To start, download the meaSERIES archive and unpack it on your hard drive. Edit the **measeries/config.php** file to indicate Uptobox and/or 1fichier API keys values that are normally available with your premium account. Indicate for example:
```
$uptobox_api_key = "d41d8cd98f00b204e9800998ecf8427e99109";
$fichier_api_key = "MM2NmQ5OTEwOTI2NmZmY2QyNzQxOWVhN";
```
You will find your API key corresponding to your Uptobox premium account [here](https://uptobox.com/?op=my_account) (it's the Token), and the one corresponding to your 1fichier premium account [here](https://1fichier.com/console/params.pl) (you will have to activate it). Save the file **measeries/config.php** after modification and transfer the **measeries** directory and its contents to your WEB server.

meaSERIES also has a function to check, at regular intervals, whether the Uptobox and 1fichier sources are still active or not. For this you need to define a cron job and point it to the **cron_check_sources.php** file. For example, to run every half hour, the cron job command will be:
```
/usr/bin/php -q /home/mywebsite/public_html/measeries/cron_check_sources.php >/dev/null 2>&1
```
where **/home/mywebsite/public_html/measeries/** is the path where meaSERIES is hosted.

# Kodi configuration

For the rest of this tutorial, we will keep as example that meaSERIES is installed at this URL http://www.mysite.com/measeries.

Start Kodi. Go to the menu System > Media Settings > Media Library > Source Management > Videos... > Add Video Source... Enter the path http://www.mysite.com/measeries/kodi and specify a source name (for example meaSERIES). Click OK. In the New Content > Folder Category window, choose the **TV Shows** option. Then choose the settings according to your preferences, but keep the content options by default. Click OK. Finally, confirm the update of the information of all the elements of this path.

# meaSERIES use

To use the meaSERIES WEB interface, with a browser, go to http://www.mysite.com/measeries. The site offers by default to add a TV Show. For example, specify *Star trek: Discovery* as the title, and click on *Add* button. The TV Show has been added to meaSERIES. Then click on the TV Show poster to access its contents.

Before adding episodes you will first have to create a season. To do this, enter the season number in the *Add Season* field and click on *Add* button. Once the season created, indicate the episode number in *Add an episode* field as well as the URL of the Uptobox or 1Fichier video source (for example https://www.1fichier.com/?yzaygyopwe) and click on *Add* button. Episode is added. Renew these operations to add more episodes and/or other seasons.

To update your TV show list into Kodi, go to System > Media Settings > Media Library > Source Management > Videos... > Options > Update Media Library. In case you host meaSERIES on a remote server, update process could  be long. Once the update is completed, you can watch TV shows directly into Kodi.

meaSERIES interface allows you to manage your TV shows list, seasons and episodes. To delete an episode, click the corresponding delete button. To delete a season, you must first delete all the season's episodes and then click on the delete season link. To delete a TV Show, you must first delete all the TV Shows seasons and then click the delete TV Shjow link.
