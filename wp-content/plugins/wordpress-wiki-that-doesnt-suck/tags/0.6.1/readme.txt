=== WordPress Wiki That Doesn't Suck ===
Contributors: jazzs3quence
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=AWM2TG3D4HYQ6
Tags: wiki, custom post types, support
Requires at least: 2.8
Tested up to: 3.0.1
Stable tag: 0.6.1

A WordPress Wiki that works.

== Description ==

Okay, so I wanted to add a wiki to my site that sells <a href="http://www.museumthemes.com">commercial themes</a>.  I've already got a support forum powered by <a href="http://www.buddypress.org">BuddyPress</a>, so the idea was that this would be for more static articles.  Problem: I hate MediaWiki.  I know BBCode and HTML and PHP and CSS and the wiki markup just baffles me.  I can never remember how to do the *simplest* things, like create a freaking link.  Really?  All I want to do is throw a `<a href="...">` in there.  If you're looking at this plugin, you know what I'm talking about.  Problem Number 2: Currently, the WordPress plugins available for what I want to do either *aren't* what I want to do, or don't work with the latest version of WordPress.  Hence this plugin.

*WordPress Wiki That Doesn't Suck* uses custom post types.  And that's pretty much it.  It creates a new custom post type (`wpwtds_article`) that can be accessed from the *Wiki != suck* menu it adds to your sidebar (!= is "not equal to" in coder jargon).  Wiki articles are posted with the `wiki` slug, so your URLs will look like `http://mydomain.com/wiki/my-cool-article`.

== Installation ==

1. Upload `wpwtds.zip` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the *Plugins* menu in WordPress.
3. Start writing articles!

== Frequently Asked Questions ==

= Can I change the default slug? =

Currently, no.  I planned on adding this in...but I didn't.  If you're interested in being a contributor and adding stuff that's missing, you're more than welcome to <a href="mailto:chris@jazzsequence.com">contact me</a>.

= Why isn't *x* feature included? =

Basically, I had a specific need, custom post types seemed like the best answer.  Plus, once it was done, I couldn't think of anything else it really needed.

= This isn't a *wiki* really, is it?  I mean, there's no real way to contribute like a real Wiki... = 

This wasn't a concern for me, since I just wanted someplace I could post support docs that was public.  That said, presumably generic WordPress user roles will still work, so if you're an *Author* you'll be able to post new wiki articles, same as anything else.

= I've installed it, now what? =

After you install the plugin, wiki articles will use your theme's default `single.php` template file.  You may want to actually *use* your wiki, as in have an actual wiki page, and for that, you'll need to add a custom template to your theme.  We'll be providing a default template to use, but more than likely you'll need to modify it slightly to fit your specific theme.

The best reference I can give you for working with custom post types (if you wanted to make your own wiki main page, for instance) is the <a href="http://codex.wordpress.org/Custom_Post_Types">Custom Post Types</a> article in the <a href="http://codex.wordpress.org">Codex</a>.  The only thing you need to know is that the post types are identified as `wpwtds_article`s.

== Screenshots ==

There are currently no screenshots.

== Changelog ==

**Version 0.6.1**

* updated `readme.txt`

**Version 0.6**

* added `with_front` qualifier to the `rewrite` option to use it's own permalink structure.

**Version 0.5**

* first public release

== Upgrade Notice ==

Nothing to see here.