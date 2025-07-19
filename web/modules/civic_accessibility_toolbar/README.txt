INTRODUCTION
------------

The Accessibility Toolbar module creates a block with buttons to resize text
and change color contrast. You can select to display text resize,
color contrast or both.
All theme font sizes must then use rem or em units.
The module is tested with Bartik, Garland, Zen Starterkit, Stark,
Oliveiro themes


REQUIREMENTS
------------

This module requires no modules outside of Drupal core.


INSTALLATION
-------
Installing the Accessibility Toolbar module is simple:

1) Copy the civic_accessibility_toolbar folder to the modules folder in
   your installation

2) Enable the module using Administer -> Extend page (/admin/modules)

3) Configure the block to work with your theme at Configuration 
   -> Accessibility Toolbar

4) Place the block into a region at Structure -> Block Layout


CONFIGURATION
-------
To change accessibility toolbar layout copy 
block--accessibility_toolbar.html.twig in your custom theme and amend.


FAQ
-------
Q: How the module remember user selection?

A: The module uses cookies (colorContrast and fontSize) 
   to remember user selection.
   These cookies don't retain any personal information and can be classified 
   as functional/necessary cookies.
   If you use any cookie control tool please protect these cookies.

Q: Fatal error occured after update to version 1.0.2?

A: Version 1.0.2 moves the module from /modules/custom folder
   to /modules/contrib folder. This should not cause an issue for most
   installation but in some cases may require apache or fpm restart.
