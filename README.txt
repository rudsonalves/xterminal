=== Blog Terminal ===
Contributors: alvesdev
Donate link: https://rralves.dev.br
Tags: terminal, cmd, xterm, unix, console, command, linux, ios
Requires at least: 5.6
Requires PHP: 6.0
Tested up to: 6.0
Stable tag: 0.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Blog Terminal provides a terminal-like box for embedding terminal commands within pages or posts.

== Description ==

Blog Terminal generates a terminal-like box that you can use to demonstrate terminal output or show the entry of terminal/console commands in a manner that is more demonstrative of actually using a Linux/Unix terminal or Windows cmd shell.

The code is a fork of Post Terminal, which is a fork of WP-Terminal which in turn is a modification of WP-Syntax, a source code highlighter plugin for Wordpress.

Unlike Post terminal, it uses `[terminal]` shorthand for the terminal box. It also shows prompt only on lines explitly set to do that.

= Basic Usage =

The most basic usage is to wrap your terminal blocks with `[terminal][/terminal]` tags. If no further options are defined within the tag a generic prompt is generated using  'user@computer' with no working directory shown. This is similar to exporting PS1="\u@\h:$ " in sh(1), setting prompt="%n@%m:$ " in csh(1), etc.
Other options available within the tag are user=userName, computer=computerName, cwd=/some/directory/path, style=ios or linux, and title=someTytle. These allow you to override the generic user@computer, title Bash and style ios settings as well as provide a 'current working directory'.
The prompt is only shown on the lines starting with '$ '. So you can mix commands with simulated terminal output.

== Installation ==

1. Unzip the plugin .zip file and upload the directory to your /wp-content/plugins/.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Create a post/page that contains a code snippet following the proper usage syntax.

== Frequently Asked Questions ==
= What is the best way to ask questions or submit patches? =
The best way to reach me is always via email: <mail@alvesdev67@gmail.com>

== Screenshots ==
1. Basic display with no configuration.
2. Basic display with <code>user</code> and <code>computer</code> configuration.
3. Basic display with <code>user</code> and <code>computer</code> and <code>cwd</code>configuration.
4. A more complete example with <code>title</code> and <code>style</code>

== Usage ==

Wrap terminal blocks with `[terminal user=username computer=computername cwd=/path/to/directory title=someTitle style=ios/linux]` and `[\terminal]`. They are all optional. "user" and "computer" will be shown if you don't provide them, and de default values of cwd is "~", from title is "Bash" and style is "ios".

**Example 1: No customized command. In this case default user@computer is the user and computer**

    [terminal]
    $ df -h
    [/terminal]

**Example 2: Customizing just the user**

    [terminal user=dak]
    $ exa -la
    [/terminal]

**Example 3: User and computer customizations**

    [terminal user=aragorn computer=suzail]
    $ php --version
    ...
    [/terminal]

**Example 4: Customizing user, computer and displaying a working directory**

    [terminal user=hansolo computer=deathstar cwd=~/go]
    $ go clean -testcache
     ...
     ... 
    [/terminal]

**Exemple 5: Change terminal style. Support ios and linux styles**

    [terminal user=root computer=linuxserver style=linux]
    $ tree .
     ... 
    [/terminal]
    
**Exemple 6: Change terminal title and style.**

    [terminal user=root computer=linuxserver title=GoLang style=linux]
    $ go test ./...
     ... 
    [/terminal]

== Changelog ==
= 0.1.0 =
* Add ios terminal header
* Add linux terminal header
* Set green color to normal users and red to root
* Add terminal title. Default Bash
* Add terminal style. Support style=linux/ios

