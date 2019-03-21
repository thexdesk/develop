---
layout: post
title: Linux from scratch
description: "For quite some time i've wanted to create a Linux from scratch build. 
Sure, Kiwi and other auto-build tools are nice, but doing it the hard way is always more fun. 
I wasn't eager to just copy/paste stuff from the book while knowing eventually i'd had to do it again. 
So creating a custom build script while doing it seemed a good idea. Check it out."
tags: [Development, Linux, Bash, Custom Linux]
image: /images/lfs-logo.png
comments: true
published: true
date: 2014-12-30
---

# Unfinished post - Not Finishedo
This post is intended for both self-reference and for showing a way to approach the creation of an LFS system. 
Following this post instructions easily take up **~2 hours**,  mainly spend on compiling.
I've succesfully completed the procedure on both openSUSE 13.1 and Linux Mint 17.


## LFS?
Linux From Scratch (LFS) is a project/book that provides step-by-step instructions for building Linux entirely from source.
 I'll be using book version 7.6, which [can be found here](http://www.linuxfromscratch.org/lfs/read.html).
 Also, all the code i've written is [on github](https://github.com/robinradic/lfsbuild).
 
 After completing LFS, there's still more to do:  
- Beyond Linux from scratch (BLFS). Networking, Window manager, desktop environment, security etc.  
- Automated Linux from scratch (ALFS). Automating the build process.  
- And more...  

**ALFS**
Without having actually read it, i find it un-doable not to instantly implement some sort of automated build mechanics. I've seen several youtube 
videos where people write all commands from the book into the prompt directly. Personally i'd rather put a chunk of commands together in a bash function
and call it. When errors occur, just alter the bad code and try again, leading up to properly working functions that can eventually be combined again = automated.
  
  
The current lfsbuild found on my github can be further automated, and i'll most likely do so in due time when i reach the point im happy with the end-result.
There's still quite some stuff i'd like to integrate, most importantly a package manager of some sorts and a bunch of customisation/personalisation alterations.
  
  
## Creating a temporary build system
I've written some helper scripts to set up a debian 7.8 virtualbox automaticly. It'll also install all required packages and ensures all pre-requesits are ok.
Using the helpers scripts to set up the temporary system, with a set distro/version lowers the chance of incompatability or whatever its called.
The scripts and other stuff im using can be viewed [on github](https://github.com/robinradic/lfsbuild). The host computer requires the following packages:  
- Virtualbox  
- Vagrant  
- 7z  
- Curl  
- Git
  


{% highlight sh %}
cd /path/to/where/i/place/mah/shit
git clone https://github.com/robinradic/lfsbuild
cd lfsbuild

# Start off with creating the installer disk. 
# init will create some dirs, download the iso and alter it, adding pre-seed to automate the installation.
# There's a chance that the download will not start. Change the iso url in config.sh to a valid download location
# check https://www.debian.org/CD/netinst/. Also change the iso MD5 if so, as it'll validate it against the iso.
./lfsbuilder init

# The download is rather small (~200mb) and altering the iso shouldn't require more then a few seconds. 
# The script will notify you of all operations and should end with the notification "Done"

# Next up is creating the virtual machine. I'd advise you to alter the settings manually to give it as much power as possible. 
# Put the vm disks on your fastest drive (ex: ssd). You'll want to do so to speed things up as much as possible. I was suprised how long 
# it took to compile everything on my pc (i7 oc@4.7, 32gb ram, 2xSSD raid). @todo <insert time here>

# This'll create a virtual box, mount the installer, install it and then make it into a vagrant base box. It'll clean up the virtual box afterwards.
./lfsbuilder make-host

# That's it for creating the temporary host/build system. Onto the next part; compiling some packages.
{% endhighlight %}

![lfsbuilder make-host progress](/images/blog-posts/linux-from-scratch/make-host.jpg "make-host progress")

After the installation is done, it should automaticly create the vagrant box, unregister the vm and notify you of it's awesomeness.

## Configuring and installing the build system
Start the vagrant box by executing 
{% highlight sh %}
./lfsbuilder start-host
{% endhighlight %}

Once completed, you will be connected with ssh in the machine. There's a shared folder there pointing to the lfsbuild directory, containing all helper scripts.
{% highlight sh %}
# Shows all helper scripts
ls /vagrant

# Fairly straight-forward. Execute the scripts in the following order
./10-makedisk.sh # Will also call 10-mountdisk once the disks are created.

# You'll now have the /mnt/lfs directory with some folders. Now download all packages. They'll be placed in /mnt/lfs/sources
./20-download-packages.sh

# Once completed, add the LFS user and login.
./30-add-lfs-user.sh
./40-login.sh
cd /vagrant
./41-first-login.sh
# If at this point you close/restart the box, you'll only have to run ./10-mountdisk.sh and ./40-login.sh to continue
{% endhighlight %}


## Compiling the packages for the build system
Now we're starting with [chapter 5 of LFS](http://www.linuxfromscratch.org/lfs/view/stable/chapter05/introduction.html).  
Before running the build script(s), alter the /vagrant/config file. If you experience problems with any of the following commands, alter the config key `runtests`. Set it to 1. 
{% highlight sh %}
# Ensure you are in the /vagrant folder
# Now do:
# ./5-build.sh build-54-to-57
# ./5-build.sh build-58-to-510
# ./5-build.sh build-511-to-518
# ./5-build.sh build-519-to-534
# OR ./5-build.sh build-all
# For the first time around, don't use build-all. Execute the 4 commands individually and ensure everything goes ok.
# There will be a lot of output generated. Just notice the colored stuff i added to see if everything goes as planned.

./5-build.sh build-54-to-57
# After completion, you'll notice a sanity check. Make sure its correct.

./5-build.sh build-58-to-510
# Another sanity check, make sure it passes.

./5-build.sh build-511-to-518

./5-build.sh build-519-to-534
{% endhighlight %}

The build system is now ready. Almost time to actually build the LFS system itself!


## Compiling the packages for the LFS client system
Now we're starting with [chapter 6 of LFS](http://www.linuxfromscratch.org/lfs/view/stable/chapter05/introduction.html). 
This will take quite abit longer compared to previous chapter and requires more manual operations.
Lets set up the file system and chroot into the client. 
{% highlight sh %}
# Change permissions
./60-own-root.sh

# Prepare the virtual kernel file system
./62-make-vfs.sh  # Will automaticly call ./62-mount-vfs.sh

# Chroot 
./64-chroot.sh
{% endhighlight %}
You'll now see a prompt similair to: `I have no name!:/#`, meaning you are now chrooted into the client system. As with the build system, the scripts
can be found under `/vagrant`.
  
  
This part will require a bit more attention. Until 653 all commands should be called manually and checked for proper compilation/no errors. Quite a few tests
will be automaticly started, ignoring the config file `runtests` value. It's vital that these tests return positive results.
{% highlight sh %}
cd /vagrant
./6-build.sh 65-createdir
./6-build.sh 66-essentials-and-symlinks

# You'll notice that the prompt changes to `bash-4.3#`.
# Now; compile time!
./6-build.sh 67-linux-api
./6-build.sh 68-man-pages
./6-build.sh 69-glibc

# Verify the output for the following command carefully. 
./6-build.sh 610-adjust

# The following commands may be combined
./6-build.sh 611-zlib
./6-build.sh 612-file
./6-build.sh 613-binutils
./6-build.sh 614-gmp
./6-build.sh 615-mpfr
./6-build.sh 616-mpc

# This one will take especially long, > 20 minutes on my system.
# When almost completed, it'll prompt providing a link
# compare the results by following the instructions
# Afterwards, continue and make sure everything is correct
./6-build.sh 617-gcc

# The following commands may be combined
./6-build.sh 618-bzip2
./6-build.sh 619-pkg-config
./6-build.sh 620-ncurses
./6-build.sh 621-attr
./6-build.sh 622-acl
./6-build.sh 623-libcap
./6-build.sh 624-sed

# After shadow is completed, you'll be prompted for a password. use `tester`
./6-build.sh 625-shadow

# The following commands may be combined
./6-build.sh 626-psmisc
./6-build.sh 627-procps-ng
./6-build.sh 628-e2fsprogs


# Mind the acl stuff, follow instructions
./6-build.sh 629-coreutils


./6-build.sh 630-iana-etc
./6-build.sh 631-m4
./6-build.sh 632-flex

# Verify tests are all ok or skipped
./6-build.sh 633-bison

./6-build.sh 634-grep
./6-build.sh 635-readline
./6-build.sh 636-bash
cd /vagrant

# The following commands may be combined
./6-build.sh 637-bc
./6-build.sh 638-libtool
./6-build.sh 639-gdbm
./6-build.sh 640-expat
./6-build.sh 641-inetutils
./6-build.sh 642-perl
./6-build.sh 643-xml-parser
./6-build.sh 644-autoconf
./6-build.sh 645-automake
./6-build.sh 646-diffutils
./6-build.sh 647-gawk
./6-build.sh 648-findutils
./6-build.sh 649-gettext
./6-build.sh 650-intltool
./6-build.sh 651-gperf
./6-build.sh 652-groff

# From here on out we'll speed things up again
./6-build.sh 653-to-670

# All packages are compiled now. Lets clean stuff up and prepare for the next part
./6-build.sh 673-clean-tmp
./6-build.sh 673-clean-tools
{% endhighlight %}


## System Configuration and Bootscripts
Now the boring part is over. Time to glue some stuff together and switch on the lights.



## Whats next?
Beyond Linux from scratch would be obvious. The plan is to get a KDE desktop environment up and running.
