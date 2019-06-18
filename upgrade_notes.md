2019-06-18 12:01

# running php upgrade upgrade see: https://github.com/silverstripe/silverstripe-upgrader
cd /var/www/upgrades/upgradeto4
php /var/www/upgrader/vendor/silverstripe/upgrader/bin/upgrade-code upgrade /var/www/upgrades/upgradeto4/share_this_simple  --root-dir=/var/www/upgrades/upgradeto4 --write -vvv --prompt
Writing changes for 4 files
Running upgrades on "/var/www/upgrades/upgradeto4/share_this_simple"
[2019-06-18 12:01:38] Applying RenameClasses to ShareThisSimpleTest.php...
[2019-06-18 12:01:38] Applying ClassToTraitRule to ShareThisSimpleTest.php...
[2019-06-18 12:01:38] Applying UpdateConfigClasses to config.yml...
[2019-06-18 12:01:38] Applying RenameClasses to ShareThisSimpleProvider.php...
[2019-06-18 12:01:38] Applying ClassToTraitRule to ShareThisSimpleProvider.php...
[2019-06-18 12:01:38] Applying RenameClasses to ShareThisSimpleExtension.php...
[2019-06-18 12:01:38] Applying ClassToTraitRule to ShareThisSimpleExtension.php...
[2019-06-18 12:01:38] Applying RenameClasses to _config.php...
[2019-06-18 12:01:38] Applying ClassToTraitRule to _config.php...
modified:	tests/ShareThisSimpleTest.php
@@ -1,4 +1,6 @@
 <?php
+
+use SilverStripe\Dev\SapphireTest;

 class ShareThisSimpleTest extends SapphireTest
 {

modified:	_config/config.yml
@@ -1,8 +1,7 @@
 ---
 Name: share_this_simple
 ---
-
 SilverStripe\CMS\Model\SiteTree:
   extensions:
-    - ShareThisSimpleExtension
+    - Sunnysideup\ShareThisSimple\Model\ShareThisSimpleExtension


modified:	src/Api/ShareThisSimpleProvider.php
@@ -2,10 +2,16 @@

 namespace Sunnysideup\ShareThisSimple\Api;

-use ViewableData;
-use ArrayList;
-use ArrayData;
-use Config;
+
+
+
+
+use SilverStripe\ORM\ArrayList;
+use SilverStripe\View\ArrayData;
+use SilverStripe\Core\Config\Config;
+use Sunnysideup\ShareThisSimple\Api\ShareThisSimpleProvider;
+use SilverStripe\View\ViewableData;
+


 class ShareThisSimpleProvider extends ViewableData
@@ -351,7 +357,7 @@
             if ($this->imageMethods) {
                 $imageMethods = $this->imageMethods;
             } else {
-                $imageMethods = Config::inst()->get("ShareThisSimpleProvider", "image_methods");
+                $imageMethods = Config::inst()->get(ShareThisSimpleProvider::class, "image_methods");
             }
             if (is_array($imageMethods) && count($imageMethods)) {
                 foreach ($imageMethods as $imageMethod) {
@@ -376,7 +382,7 @@
                 if ($descriptionMethod = $this->descriptionMethod) {
                     //do nothing
                 } else {
-                    $descriptionMethod = Config::inst()->get("ShareThisSimpleProvider", "description_method");
+                    $descriptionMethod = Config::inst()->get(ShareThisSimpleProvider::class, "description_method");
                 }
                 if ($descriptionMethod) {
                     if ($this->object->hasMethod($descriptionMethod)) {

modified:	src/Model/ShareThisSimpleExtension.php
@@ -2,8 +2,11 @@

 namespace Sunnysideup\ShareThisSimple\Model;

-use DataExtension;
-use ShareThisSimpleProvider;
+
+
+use Sunnysideup\ShareThisSimple\Api\ShareThisSimpleProvider;
+use SilverStripe\ORM\DataExtension;
+




Writing changes for 4 files
✔✔✔
# running php upgrade inspect see: https://github.com/silverstripe/silverstripe-upgrader
cd /var/www/upgrades/upgradeto4
php /var/www/upgrader/vendor/silverstripe/upgrader/bin/upgrade-code inspect /var/www/upgrades/upgradeto4/share_this_simple  --root-dir=/var/www/upgrades/upgradeto4 --write -vvv
Writing changes for 1 files
Running post-upgrade on "/var/www/upgrades/upgradeto4/share_this_simple"
[2019-06-18 12:01:50] Applying ApiChangeWarningsRule to ShareThisSimpleTest.php...
[2019-06-18 12:01:50] Applying UpdateVisibilityRule to ShareThisSimpleTest.php...
[2019-06-18 12:01:50] Applying ApiChangeWarningsRule to ShareThisSimpleProvider.php...
[2019-06-18 12:01:50] Applying UpdateVisibilityRule to ShareThisSimpleProvider.php...
[2019-06-18 12:01:50] Applying ApiChangeWarningsRule to ShareThisSimpleExtension.php...
[2019-06-18 12:01:50] Applying UpdateVisibilityRule to ShareThisSimpleExtension.php...
[2019-06-18 12:01:50] Applying ApiChangeWarningsRule to _config.php...
[2019-06-18 12:01:50] Applying UpdateVisibilityRule to _config.php...
modified:	tests/ShareThisSimpleTest.php
@@ -6,7 +6,7 @@
 {
     protected $usesDatabase = false;

-    protected $requiredExtensions = [];
+    protected $required_extensions = [];

     public function TestDevBuild()
     {

Warnings for tests/ShareThisSimpleTest.php:
 - tests/ShareThisSimpleTest.php:9 SilverStripe\Dev\SapphireTest->requiredExtensions: Renamed to required_extensions
Writing changes for 1 files
✔✔✔
# running php upgrade inspect see: https://github.com/silverstripe/silverstripe-upgrader
cd /var/www/upgrades/upgradeto4
php /var/www/upgrader/vendor/silverstripe/upgrader/bin/upgrade-code inspect /var/www/upgrades/upgradeto4/share_this_simple  --root-dir=/var/www/upgrades/upgradeto4 --write -vvv
Array
(
    [0] => Running post-upgrade on "/var/www/upgrades/upgradeto4/share_this_simple"
    [1] => [2019-06-18 12:02:11] Applying ApiChangeWarningsRule to ShareThisSimpleTest.php...
    [2] => PHP Fatal error:  Cannot redeclare static SilverStripe\Dev\SapphireTest::$required_extensions as non static ShareThisSimpleTest::$required_extensions in /var/www/upgrades/upgradeto4/share_this_simple/tests/ShareThisSimpleTest.php on line 17
)
