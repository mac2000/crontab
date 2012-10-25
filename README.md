Crontab
=======

Simple script to manage users crontab

Requirements
------------

In order for this script to work [PAM](http://pecl.php.net/package/PAM) module must be installed.

    sudo pecl install PAM


About users crontab
-------------------

To show list of currently scheduled jobs use `crontab -l`.

To reload crontab use `crontab -u <username> <file>`, for example `crontab -u mac /home/mac/crontab`.

Timings
-------

`*` - every
`5` - concrete
`1,2` - concrete list
`1-5` - concrete range
`*/2` - every even (0, 2, 4, .., 58)
`1,2,3/2` - every even in list (1, 3)
`1-5/2` - every even (by index) in range (1, 3, 5)

Regex to match scheduled job
----------------------------

    /(?P<disabled>#?)\s*(?P<minute>[\*\d\/\-,]+)\s+(?P<hour>[\*\d\/\-,]+)\s+(?P<day>[\*\d\/\-,]+)\s+(?P<month>[\*\d\/\-,]+)\s+(?P<day_of_week>[\*\d\/\-,]+)\s+(?P<command>[^#$]+)#*\s*(?P<name>.*?)$/


TODO
----

http://www.corntab.com/pages/crontab-gui

