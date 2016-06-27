<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see bootstrap_preprocess_page()
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see bootstrap_process_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup templates
 */

$systempage = 'no';
$systemtitles = array('Site map', 'Search');
if(in_array($title, $systemtitles)) {
  $systempage = 'yes';
}

?>

<div id="page" class="hfeed site">
  <div id="masthead-wrap">
    <header id="masthead" class="site-header" role="banner">

      <div id="cat-nav" class="clear">
        <div class="menu-menu-1-container">

          <?php if (!empty($page['navigation'])): ?>
            <?php print render($page['navigation']); ?>
          <?php endif; ?>

        </div>
      </div>

      <hgroup>
        <?php if ($logo): ?><a class="coa-link" href="<?php print $front_page; ?>" title="Home"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>"/></a><?php endif; ?>
        <div class="site-brand">
          <?php if (!empty($site_name)): ?><h1 class="site-title">
            <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><?php print $site_name; ?></a>
          </h1><?php endif; ?>
          <h2 class="site-description"></h2>
        </div>
      </hgroup>

      <div class="clearfix"></div>

    </header><!-- #masthead .site-header -->

  </div><!-- #masthead-wrap -->

  <?php print render($page['header']); ?>

  <div id="main" class="site-main">

    <?php if (!empty($page['highlighted'])): ?>
      <div class="highlighted jumbotron"><?php print render($page['highlighted']); ?></div>
    <?php endif; ?>

    <div id="primary" class="content-area">
      <div id="content" class="site-content" role="main">

        <?php if (!isset($node) && $systempage == 'yes'): ?>
        <article class="post type-post status-publish format-standard hentry <?php print $classes; ?> clearfix"<?php print $attributes; ?>>
          <header class="entry-header">
            <?php endif; ?>

        <a id="main-content"></a>
        <?php if (!isset($node)): ?>
        <?php print render($title_prefix); ?>
        <?php if (!empty($title)): ?>
          <h1 class="entry-title page-header"><span><?php print $title; ?></span></h1>
        <?php endif; ?>
        <?php print render($title_suffix); ?>
        <?php endif; ?>

        <?php print $messages; ?>
        <?php if (!empty($tabs)): ?>
          <?php print render($tabs); ?>
        <?php endif; ?>
        <?php if (!empty($page['help'])): ?>
          <?php print render($page['help']); ?>
        <?php endif; ?>
        <?php if (!empty($action_links)): ?>
          <ul class="action-links"><?php print render($action_links); ?></ul>
        <?php endif; ?>

            <?php if (!isset($node) && $systempage == 'yes'): ?>
          </header>
            <div class="entry-content">
              <?php endif; ?>
        <?php print render($page['content']); ?>

        <?php if (!isset($node) && $systempage == 'yes'): ?>
        </div>
          <?php endif; ?>

      </div><!-- #content .site-content -->
    </div><!-- #primary .content-area -->

    <div id="secondary" class="widget-area" role="complementary">

      <?php if (!empty($page['sidebar_first'])): ?>
        <aside class="col-sm-3" role="complementary">
          <?php print render($page['sidebar_first']); ?>
        </aside>  <!-- /#sidebar-first -->
      <?php endif; ?>
      
      <?php if (!empty($page['sidebar_second'])): ?>
        <aside class="col-sm-4 right-sidebar" role="complementary">
          <?php print render($page['sidebar_second']); ?>
        </aside>  <!-- /#sidebar-second -->
      <?php endif; ?>

    </div><!-- #secondary .widget-area -->

  </div><!-- #main .site-main -->
  <div id="colophon-wrap">
    <footer id="colophon" class="site-footer" role="contentinfo">
      <div id="copyright" class="wrapper dontPrint">
        <?php if (!empty($page['footer'])): ?>
          <footer class="footer <?php print $container_class; ?>">
            <?php print render($page['footer']); ?>
          </footer>
        <?php endif; ?>
      </div>
    </footer><!-- #colophon .site-footer -->
  </div><!-- #colophon-wrap -->
</div><!-- #page .hfeed .site -->








































