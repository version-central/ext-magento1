# K10r_VersionCentral

## Support

**Magento Version**

* Tested versions: 1.9.2.4
* The extension is probably supported down to 1.7, just give it a try ;-)

## Installation

### Manual

Download the [current ZIP](https://github.com/version-central/ext-magento1/archive/master.zip) and copy the files from `src/` to your shop directory. Ensure that the directory structure matches.

### modman

You can also install the module via [modman](https://github.com/colinmollenhour/modman).

Execute the following command in your shop directory:

```
modman clone https://github.com/version-central/ext-magento1
```

## Configuration

Afterwards open `System > Configuration > General > VersionCentral` in your Magento backend and add your application token from the VersionCentral project. After saving the configuration, information should appear for your application in the VersionCentral dashboard.

**Note:** Ensure that your Magento cronjob is configured and running correctly.

## Contact

If you have any problems or suggestions, just email us at [versioncentral@k10r.de](mailto:versioncentral@k10r.de).