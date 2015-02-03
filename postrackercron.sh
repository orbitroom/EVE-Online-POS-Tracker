#!/bin/sh
#cd ~/your_path_to_tracker
#cd /var/www/EVE-Online-POS-Tracker
#/usr/local/bin/php mail.php
/usr/bin/php5 cron_updateallianceinfo.php
/usr/bin/php5 cron_updatesov.php

