pigram :pig::ram:
==

A Raspberry Pi powered Instagram Feed (h/t to @larsonholgers [for his work and original idea](http://itscalledlove.com/#work))

This has been tested on the A+, B, B+ and Pi 2 models.

Start with a fresh install of Raspbian (tested with 2015-05-05-raspbian-wheezy on a 4GB SD card) and follow the instructions below to configure your Pi.

## RasPi Config ##
`sudo raspi-config`
- Change password
- Expand filesystem
- Set timezone and keyboard options
- Set a modest overclock
- Set hostname if desired
- Change RAM split to allocate only 16MB to GPU
- Reboot system

## Setup networking and update software packages ##
This is most easily acheived with `startx` and the networking GUI (or `wpa_gui`)

Update and upgrade software packages with:
`sudo apt-get update && apt-get upgrade -y`

## Install LAMP ##
```bash
sudo apt-get install apache2 php5 libapache2-mod-php5 php5-curl
sudo apt-get install mysql-server mysql-client php5-mysql phpmyadmin
```

When setting up MySQL, don't forget to save the password for the root user somewhere safe and select apache2 when prompted

## Set webroot file privileges, clone repo and initialise config ##
```sh
sudo chown -R pi /var/www
cd /var/www
git clone https://github.com/GitTH/pigram.git
cd pigram
cp setup-example.php setup.php
```

## Create SQL table ##
- Navigate to [phpMyAdmin in your Pi browser](http://localhost/phpmyadmin/).
- Create a new user and database, recording database connection details in `setup.php`
- Run the following SQL command on the new database to create the table

```sql
CREATE TABLE IF NOT EXISTS `social_instagram` (
  `instagram_shortcode` varchar(48) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `images_low_resolution` varchar(255) NOT NULL,
  `images_high_resolution` varchar(255) NOT NULL,
  `type` char(5) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`instagram_shortcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

## Create an Instagram API key ##
[Register your Instagram Client ID](https://instagram.com/developer/clients/register/) and add it to `setup.php`

## Detect screen size and run in kiosk mode ##
h/t to @WatershedArts solution for [fullscreen browser kiosks](http://blogs.wcode.org/2013/09/howto-boot-your-raspberry-pi-into-a-fullscreen-browser-kiosk/) which requires the following additional packages:
`sudo apt-get install matchbox chromium x11-xserver-utils xwit sqlite3 libnss3`

`sudo nano /etc/rc.local` and add the following before the final `exit 0` line:
```sh
# Wait for the TV-screen to be turned on...
while ! $( tvservice --dumpedid /tmp/edid | fgrep -qv 'Nothing written!' ); do
	bHadToWaitForScreen=true;
	printf "===> Screen is not connected, off or in an unknown mode, waiting for it to become available...\n"
	sleep 10;
done;

printf "===> Screen is on, extracting preferred mode...\n"
_DEPTH=32;
eval $( edidparser /tmp/edid | fgrep 'preferred mode' | tail -1 | sed -Ene 's/^.+(DMT|CEA) \(([0-9]+)\) ([0-9]+)x([0-9]+)[pi]? @.+/_GROUP=\1;_MODE=\2;_XRES=\3;_YRES=\4;/p' );

printf "===> Resetting screen to preferred mode: %s-%d (%dx%dx%d)...\n" $_GROUP $_MODE $_XRES $_YRES $_DEPTH
tvservice --explicit="$_GROUP $_MODE"
sleep 1;

printf "===> Resetting frame-buffer to %dx%dx%d...\n" $_XRES $_YRES $_DEPTH
fbset --all --geometry $_XRES $_YRES $_XRES $_YRES $_DEPTH -left 0 -right 0 -upper 0 -lower 0;
sleep 1;

# Uncomment this line if you are using a custom splash screen with fbi
# killall fbi

if [ -f /boot/xinitrc ]; then
	ln -fs /boot/xinitrc /home/pi/.xinitrc;
	su - pi -c 'startx' &
fi
```

`sudo nano /boot/config.txt` and insert the following to the bottom of the config file:
```sh
# 1920x1080 at 32bit depth, DMT mode
disable_overscan=1
framebuffer_width=1920
framebuffer_height=1080
framebuffer_depth=32
framebuffer_ignore_alpha=1
hdmi_pixel_encoding=1
hdmi_group=2
```

`sudo nano /boot/xinitrc` and insert the following:
```sh
#!/bin/sh
while true; do

	# Clean up previously running apps, gracefully at first then harshly
	killall -TERM chromium 2>/dev/null;
	killall -TERM matchbox-window-manager 2>/dev/null;
	sleep 2;
	killall -9 chromium 2>/dev/null;
	killall -9 matchbox-window-manager 2>/dev/null;

	# Clean out existing profile information
	rm -rf /home/pi/.cache;
	rm -rf /home/pi/.config;
	rm -rf /home/pi/.pki;

	# Generate the bare minimum to keep Chromium happy!
	mkdir -p /home/pi/.config/chromium/Default
	sqlite3 /home/pi/.config/chromium/Default/Web\ Data "CREATE TABLE meta(key LONGVARCHAR NOT NULL UNIQUE PRIMARY KEY, value LONGVARCHAR); INSERT INTO meta VALUES('version','46'); CREATE TABLE keywords (foo INTEGER);";

	# Disable DPMS / Screen blanking
	xset -dpms
	xset s off

	# Reset the framebuffer's colour-depth
	fbset -depth $( cat /sys/module/*fb*/parameters/fbdepth );

	# Hide the cursor (move it to the bottom-right, comment out if you want mouse interaction)
	xwit -root -warp $( cat /sys/module/*fb*/parameters/fbwidth ) $( cat /sys/module/*fb*/parameters/fbheight )

	# Start the window manager (remove "-use_cursor no" if you actually want mouse interaction)
	matchbox-window-manager -use_titlebar no -use_cursor no &

	# Start the browser (See http://peter.sh/experiments/chromium-command-line-switches/)
	chromium  --app=http://localhost/pigram/

done;

```

## Setup cron to retrieve new images ##
`crontab -e`
Insert the following line:
`*/5 * * * * curl http://localhost/pigram/data/import.php?userid=12345`
This will import new photos every 5 minutes from user 12345.  Remember to change the number after userid with the Instagram User ID you want to query.  You can [learn more about cron here](https://www.raspberrypi.org/documentation/linux/usage/cron.md).

It is also possible to use `userfeed=1` to import the home feed of an authenticated user (currently undocumented)

## Other Tweaks ##
**Hide boot messages** ([source](http://ananddrs.com/2013/09/18/rpi-hide-boot-msg/))
`sudo nano /boot/cmdline.txt`
Replace `console=tty1` with `console=tty2` to output to second console (accessible with Alt+F2)
Add `logo.nologo loglevel=3` to the end of the string to disable the Pi logo and non-critical kernel log messages.

**Custom splash screen image** ([source](http://www.edv-huber.com/index.php/problemloesungen/15-custom-splash-screen-for-raspberry-Sourcpi-raspbian))
`sudo apt-get install fbi`
Copy your image (suggested 1920x1080 PNG) to `/etc/splash.png`
`sudo nano /etc/init.d/asplashscreen` and insert the following:

```sh
#! /bin/sh
### BEGIN INIT INFO
# Provides:          asplashscreen
# Required-Start:
# Required-Stop:
# Should-Start:      
# Default-Start:     S
# Default-Stop:
# Short-Description: Show custom splashscreen
# Description:       Show custom splashscreen
### END INIT INFO

do_start () {

    /usr/bin/fbi -T 1 -noverbose -a /etc/splash.png
    exit 0
}

case "$1" in
  start|"")
    do_start
    ;;
  restart|reload|force-reload)
    echo "Error: argument '$1' not supported" >&2
    exit 3
    ;;
  stop)
    # No-op
    ;;
  status)
    exit 0
    ;;
  *)
    echo "Usage: asplashscreen [start|stop]" >&2
    exit 3
    ;;
esac

:

```

Make the boot script executable with:
`sudo chmod a+x /etc/init.d/asplashscreen`
`sudo insserv /etc/init.d/asplashscreen`

To free up memory, you can kill this process before `startx` by uncommenting the `killall fbi` line in the `/etc/rc.local` file above.

You can also minimise the text that is displayed when `fbi` is terminated by commenting out the line in `/etc/inittab` that starts a getty process (the login prompt) on tty1.

**Expanded swap file**
If you have an A+ model Pi with only 256MB of RAM, you may like to increase the size of the swap file from 100MB to 256MB by editing the config with:
`sudo nano /etc/dphys-swapfile`

Note: you should read about the effects this can have on the lifespan of your SD card. This tweak should see the A+ finish boot and display photos in around two minutes.

**Offline deployment**
If you need to deploy this offline it is possible to save static copies of desired Instagram photos onto the SD card via a card reader and create a symbolic link to access the photos.  For example:
`ln -s /boot/pigram /var/www/pigramimgs`

You will also need to change the ajax function in `pigram.js` to use local URLs:
`val.url = 'http://localhost/pigramimgs/'+val.instagram_shortcode+'.jpg`
