<?php

include("includes/declarations.php");
$crawltsite=2;
require_once("/var/chroot/home/content/44/10809344/html/crawltrack/crawltrack.php");
$thismonth=date(m);
$thisday=date(d);
$thisdate="$thismonth$thisday";
$thisyear=date(Y);

$htoday="$thisyear$thismonth$thisday";
$crawltsite=1;

$today="$thisyear$thismonth$thisday";
$titletag="";


include("includes/dbconnect.php");
if($link)
{

}
else
{
	$error = "<b>Error:</b>  No Database connection.\n";
}
include("includes/headerinc.php");

print <<<ENDTAG
<div class="clearfix"></div>
	<article id="content">
ENDTAG;
if($error)
{
	print "<span class=\"error\">$error</span>\n";
}
else
{

print <<<ENDTAG
<!-- use this for 2 col -->
	<aside id="in_this_section">
		<h2>In This Section</h2>
		<p><a href="portfolio.php">Web Portfolio</a></p>
		<p><a href="/playground" target="_blank">Code Portfoliio</a>
		<br />(opens new window)</p>
		<p>Resume</p>
	</aside>
	<article id="content_col">
		<h1 class="tac">Resume</h1>
		<p>Click a heading below to expand the selection</p>
		
		<header class="resume_section" id="location">
			Desired Target Locations
		</header>
		<article class="resume_section_content" id="location_content">
			<p>Wish to work preferably in Fremont, Newark, Union City, Milpitas, Pleasanton, Dublin, San Ramon, Walnut Creek. Will give consideration to North San Jose, Sunnyvale, Santa Clara, and parts of Mountain View if I can work my hours around peak traffic times. <span class="fwb fsi">Will not consider San Francisco or relocation.</span>
		</article>
		<header class="resume_section" id="summary">
			Summary
		</header>
		<article class="resume_section_content" id="summary_content">
			<p>Over 10 years of hands-on experience developing websites through their entire lyfe cycle.  Energetic, self-motivated, multi-faceted programmer/developer with an unquenchable thirst for learning new technology.</p>
		</article>
		<header class="resume_section" id="skills">
			Relavent Skills
		</header>
		<article class="resume_section_content" id="skills_content">
			<p><span class="fwb">Web specific:</span>  HTML5, CSS3, responsive design, SASS, Compass, PHP MySQL, jQuery, AJAX, JSON.  CMS experience includes WordPress and Drupal plus my very own which I developed.</p>
			<p><span class="fwb">Web Applications:</span>  I have developed various web applications:  My very own Content Management system, mentioned above, photo sharing, retail management for online stores, and an email broadcasting system.</p>
			<p>Expertise with Adobe Photoshop and Illustrator, also create printed materials with Adobe InDesign.</p>
			<p>Experience working in an Agile environment with SCRUM.</p>
			<p>Experience with subversion control (such as Tortoise SVN, GIT, etc.)</p>
			<p>Experience working from the command line and running web services such as Apache.</p>
		</article>
		<header class="resume_section" id="platforms">
			Platforms
		</header>
		<article class="resume_section_content" id="platforms_content">
			<p>Windows O/S (Windows 95, 98, NT, 2000, XP, Vista, 7), Linux, Solaris, Macintosh.</p>
		</article>
		<header class="resume_section" id="software">
			Software/Development Environments
		</header>
		<article class="resume_section_content" id="software_content">
			<p>Adobe Photoshop CS3, Illustrator CS3 and Acrobat, Dreamwever, InDesign, Sharepoint, Fireworks, Microsoft Office Suite, Microsoft Visual Studio, PageMaker, Quark Xpress.</p>
		</article>
		<header class="resume_section" id="education">
			Education
		</header>
		<article class="resume_section_content" id="education_content">
			<p>Most of my computer language skills have been self-taught. If I don't know something, I will read about it and apply what I have read directly to the application I am developing. I have acquired some formal training:</p>
			<ul>
				<li>Graphic Design and Layout - San Jose City College, San Jose</li>
				<li>Computer Science - De Anza College, Cupertino</li>
				<li>Unix Systems Administration - Ohlone College, Fremont</li>
				<li>jQuery - online course - Codeschool.com</li>
				<li>HTML5 and CSS3 - online course - Codeschool.com</li>
			</ul>
		</article>
		<header class="resume_section" id="misc">
			Miscellaneous
		</header>
		<article class="resume_section_content" id="misc_content">
			<p>10+ years experience of layout and design. Graphic Artist, Technical writer; Type 140+ wpm, have administered multi-platform LAN in my home.</p>
		</article>
		<header class="resume_section" id="Career Highlights">
			Career Highlights
		</header>
		<article class="resume_section_content" id="career_content">
			<p><span class="fwb">Silicon Valley Peripherals - September, 2013 - March, 2014 - Front End UI Developer/Fullstack back-end developer, Social Media, Webmaster - Fremont, CA</span>
			<br />Principal Web Developer for two sites - one is their corporate site which highlights the company history and its products.  Was brought in as an in house web developer to transform the existing, outdated sites to modern, responsive sites.  Completely redesigned the look and feel using PhotoShop to mock up composites, and then creating the new skins with CSS3/HTML5 in a responsive layout.  Back-end programming a CMS to make updating and maintaining the site easy with php/MySQL.  Also created printed marketing materials and created logos and necessary graphics.</p>

			<p><span class="fwb">Your Great Website.com - June, 2013 - Present  Web Applications developer (frontend UI Developer, Backend Developer) - Fremont, CA</span>
			<br />Working with small to medium sized businesses in improving and/or creating their websites., using PHP/MySQL, CSS3, HTML5, jQuery.  Working with different Content Management Systems such as WordPress and a niche system for wineries called Vin65.  Perform all aspects of development, debugging, and creation.  Developed and coded websites, implemented the use of a custom content management system I coded in php/MySQL.  Deployed many websites for small to medium sized businesses.  Worked with Drupal and Drupal Commons in various projects.</p>

			<p>Created and worked with Wordpress - did many installations, and performed tasks such as  choosing plugins, user administration and management, functionality, and customization where necessary.  Was able to transplant the database from one server to another using PHPMyAdmin and command line MySQL.  Also have imported data from CSVfiles into MySQL databases for inventory management systeme, etc.</p>

			<p><span class="fwb">Process Tech Solutions,  Inc.  February, 2013 - June, 2013 Full stack developer:  Front End UI Developer, Backend Developer - Remote</span>
			<br />Complete, end to end website development for a startup (at this writing I cannot be very descriptive as I am bound by NDA's).   All aspects of site development including the graphic design, layout, front end, backend.  Done in HTML5 with a php/MySQL framework.    Site requires membership to use, so a registration process and authentication is part of the functionality of the site.  The contract concluded in early June.  Designed, coded, programmed and deployed site.  Provided session management to preserve the state of session variables and keep track of logged in users and their activities on the site.</p>

			<p><span class="fwb">Your Great Website.com -  January, 2012 - January, 2013 - Fremont, CA </span>
			<br />Have served in several roles with private clients as well as contracting firms in the following types of projects as both a front end UI Developer and backend developer:
			<ul>
				<li>Drupal/Hybrid Site - this site was for a large, global organization which needed members to purchase memberships, register for conferences, participate in committees - they client wanted a Drupal site but their feature requirements  were not 'out of the box' Drupal modules.  It was necessary for me to "bootstrap" Drupal in my custom programs, all hand-coded in php.  The UI had a lot of jQuery features to make the user experience more interactive.</li>

				<li>E-Commerce and small business sites - done with my own custom content management system so the customers can update their site content, photos, etc.  Designed, coded, and deployed sites.</li>

				<li>One of my customers was a high tech swimming equipment company.  Their site was done 100% in Flash and they had no sales and they hired me to re-do their site.  I did the site in HTML and within 3 months, they had 100% improvements in their online sales.</li>
			</ul>
			
			<p><span class="fwb">Various, Inc. ( FriendFinder) - Sunnyvale, CA - April, 2011 - January 2012 - Front End UI Developer</span>
			<ul>
				<li>Debugged live issues (formatting, cross browser problems, functionality issues) assigned to me via JIRA. </li>
				<li>Worked  from engineering specs to implement new features and recreate modern versions of old features, utilizing  the jQuery framework, heavy CSS, html5 and CSS3.</li>
				<li>Worked within our template system to troubleshoot and locate site specific code within a myriad of conditionals.  Since I have a working knowledge and many years hands-on with the perl programming language, it was advantageous.</li>

				<li>Took advantage of training and training materials offered to me to further my knowledge in jQuery, CSS, and HTML5.</li>
				<li>Used "Agile" methodology for projects which involved daily scrums.</li>
				<li>Gathered requirements from project managers and stakeholders for enhancements, improvements and promotions.</li>
				<li>Created layouts and utilized CSS to target localization issues causing formatting breaks.  Tested in all browsers.</li>
				<li>Utilize FireBug's html, css, DOM and JavaScript console for debugging and streamlining page content.</li>
			</ul>

			<p><span class="fwb">Consulting/Contracting - January, 2006 - March, 2011 Front end UI Developer, Back-end Developer </span>
			<br />Performed  in a variety of short-term roles in all aspects of website development, maintenance, debugging, etc.  Worked with several different content management systems; some were proprietary, and  others more common such as Vignette, WordPress, SharePoint and Drupal.   Created new layouts from composites, created sites from the ground up utilizing PHP/MySQL, HTML, CSS and jQuery.  Companies included Robert Half (Corporate HQ) , Microsoft, eBay, Periche-Thomas Enterprises and Moonstone Interactive.  </p>

			<p><span class="fwb">US Masters Swimming Association - Remote -  Website Programmer/Webmaster (Consultant) - July 2004 - June, 2006</span></p>
			<ul>
				<li>Participated heavily in redesign of usms.org contributing graphic composites - Front end UI Development.</li>
				<li>Developed part of new content management system (written in php/MySQL) and participated heavily in converting old site into new, dynamic site (Back-end development)</li>
			</ul>

		</article>
		<header class="resume_section" id="portfolio">
			Website Portfolio
		</header>
		<article class="resume_section_content" id="portfolio_content">
			<p><a href="http://www.klinkerbrickwinery.com" target="_blank">Klinkerbrick Winery</a> - Responsive Website</p>
			<p><a href="http://www.mccaycellars.com" target="_blank">McCay Cellars</a> - Responsive Website</p>
			<p><a href="http://www.besttreeservice.com" target="_blank">Best Tree Services - Custom WordPress Site</p>
			<p><a href="http://www.thegasketstoreonline.com" target="_blank">The Gasket Store</a> - E-Commerce site selling refrigeration gaskets, all managed by my content management system I wrote in php/MySQL.</p>
			<p><a href="http://www.oaklandhog.org" target="_blank">Oakland Harley Owners Group</a> - Oakland Harley Owners Group - Volunteer organization of Harley owners. Site runs on my custom php/MySQL Content Management System.</p> 
		</article>
		<header class="resume_section" id="personal">
			Personal
		</header>
		<article class="resume_section_content" id="personal_content">
			<p>Hobbies and interests include:</p>
			<ul>
				<li>Fitness</li>
				<li>Stained glass and glass crafts</li>
				<li>Gourmet level cooking (but lean and healthy)</li>
				<li>Enjoying my cats and tortoise</li>
				<li>Upgrading my development skills</li>
			</ul>
		</article>
		<p class="fwb tac fsi">Additional Web Credits & References available upon request</p>
	</article>
<!--2 col end-->
ENDTAG;
}
print <<<ENDTAG
	</article><!--content end-->
ENDTAG;
include("inclues/footerinc.php");
?>

