Whats is this?
==============
This project is a digital scoring system for badminton. It uses the standard rule sets of badminton (best of 3 games rally point system, max 30 points).

It's mainly seprerated in 3 parts

- server components (setup for matches, players, etc)
- monitors (show the actual points/games/names)
- input devices (a tablet to change the score)

What is it capable of / my setup?
=================================
We tested it so far on 12 courts in parallel.
Tablets can be anything (Android Tablets, iPad, iPhone, iPod-Touch, Windows-Tablet ... anything which has a browser an can be touched).

- my server is running on a 6 years old EEEPC running Ubuntu
- my monitors/tv's are currently hooked up to some windows laptop running chrome or firefox in fullscreen mode
- my monitors/tv's will soon be running of a raspberry pi in kiosk mode (see https://github.com/mathse/rpi-sdcard-automation)
- my tablets are at the moment 4 Touchlet X2 and 8 Coby Kyros with a dolphin browser in full screen mode

How do i set it up?
===================
clone the project to your apache's document root and run "bash ./setup.sh"

