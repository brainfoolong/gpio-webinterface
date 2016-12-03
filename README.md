# Web GUI for OMX Player on a Raspberry Pi
This web GUI give you easy control of your OMX player, directly via your browser. Start your video and audio files directly with your smartphone, tablet or desktop browser. This GUI is the successor to the first, simpler version of omxwebgui at https://github.com/brainfoolong/omxwebgui/.

<img src="https://brainfoolong.github.io/omxwebgui-v2/images/screenshot-1.png?2" width="30%">
<img src="https://brainfoolong.github.io/omxwebgui-v2/images/screenshot-2.png?2" width="30%">
<img src="https://brainfoolong.github.io/omxwebgui-v2/images/screenshot-3.png?2" width="30%">

## Features
* Start and stop media files via webinterface
* Responsive design - Great for desktop, smartphone or tablets
* All hotkeys from omxplayer mapped to the webpage
* Multilanguage
* Permanent playlist - Just add folders, files and streams
* Search for filenames with wildcards
* Mark of already viewed videos

## How to contribute
Feel free to send pull requests. Create an issue for a new feature BEFORE you do some coding. We should talk about that before. Translations are pretty straight forward, you can just add them without an issue. 

## Requirements
It is strongly recommended to use it just with the php-cli. Do not use it in combination with a webserver, it will not work. Just use it as described bellow. Only PHP is required. It is also PHP7 compatible.
`sudo apt-get install php5-cli`

## Installation
Download/Clone/Unpack the whole script to a folder you like. Create a php webserver listening on port 4321, you can change the port to whatever you want. Start this with the same user that you need to play the videos. Please do not use apache or other server's to run the php script, it will probably not work.

`php -S 0.0.0.0:4321 -t YOURPATHTOOMXWEBGUIFOLDER > /dev/null 2>&1 &`

Open the webpage with http://IPTOYOURPI:4321

## Autostart
To enable autostart on reboot just add the following line to your crontab. Do this with the same user that you need to play the videos. No `sudo` required.
Add the following line to crontab with `sudo crontab -e` to start the simple php webserver on reboot

`@reboot php -S 0.0.0.0:4321 -t YOURPATHTOOMXWEBGUIFOLDER > /dev/null 2>&1 &`

## Troubleshooting
* If you have troubles with write permissions just give the `data` and `tmp` folder the 777 permission.
