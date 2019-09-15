# WordPress Easy Popular Posts List Plugin
![GPL license](https://img.shields.io/static/v1?style=for-the-badge&label=License&labelColor=555&message=GPL%202&color=0d7ebf&link=http://perso.crans.org/besson/LICENSE.html) ![Built with PHP](https://img.shields.io/static/v1?style=for-the-badge&logo=PHP&logoColor=white&label=BUILT%20WITH&labelColor=777BB4&message=PHP&color=555&link=https://www.php.net) ![Built with SASS](https://img.shields.io/static/v1?style=for-the-badge&logo=Sass&logoColor=white&label=BUILT%20WITH&labelColor=CC6699&message=SASS&color=555&link=https://sass-lang.com) ![Powered by WordPress](https://img.shields.io/static/v1?style=for-the-badge&logo=WordPress&logoColor=white&label=POWERED%20BY&labelColor=21759B&message=WORDPRESS&color=555&link=https://wordpress.org) ![Code on GitHub](https://img.shields.io/static/v1?style=for-the-badge&logo=GitHub&logoColor=white&label=CODE%20ON&labelColor=181717&message=GITHUB&color=555&link=https://github.com/iftee/ift-popular-posts)

## Features
- No coding required = Win :sunglasses:
- Easy drag-and-drop widget
- Option to limit number of popular posts to show
- Option to show/hide post date
- Option to select default thumbnail images for post that do not have featured images
- Option to choose thumbnail width and height _(currently 150px x 150px is maximum, I don't know why you'd want larger than that)_
- Option to limit post title length by number of words
- Option to show/hide post excerpt
- Option to limit post excerpt length by number of words

## How To Use
- Clone or download the repository in your plugin folder _wp-content > plugins_
- Activate the plugin from _Dashboard > Plugins > Installed Plugins_ page
- Go to _Dashboard > Appearance > Widget page_ and you'll find "Easy Popular Posts" under _Available Widgets_ list
- Add the widget to any of your Sidebars to start working
Here is a screen grab of configuring this widget

![Widget Settings](screenshot.png)

## Dependency Requirement
PHP 5.3+, because I use PHP <code>namespace</code> to avoid any unwanted collision of my functions and classes with the functions and classes of the theme or other plugins.

## Underlying Logic
Simple. Every view to a certain post is counted. The posts with the highest view counts are considered as the most popular posts.

## Style and Appearance
The styling will vary based on your theme and your custom CSS. But here is a screen grab using Twenty Seventeen theme.

![Preview on Twenty Seventeen Theme](theme-preview.png)

## Unit Test
I've tested this plugin with the unit test data from [WP Test](http://wptest.io).

## Future Plans
This plugin was a one-sitting code project during a weekend night. Obviously it can have a lot of improvements. Here is my personal checklist:
- [ ] Adding option for limiting posts based on categories
- [ ] Adding option for limiting posts based on tags
- [ ] Adding a properly interactive way of uploading the default thumbnail image
- [ ] Adding options to disaply which categories and tags a post belongs to
- [ ] Adding a [shortcode] option to call the widgets from anywhere
- [ ] Adding options with two WYSWYG type editors in the widget to add content that will be displayed just before the post list and just after the post list
- [ ] Adding options to exclude current post and sticky post from the popular post list
- [ ] Adding support for custom pots types
- [ ] Adding option for limiting posts based on custom taxonomy
