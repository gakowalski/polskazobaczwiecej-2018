<?php
defined('_JEXEC') or die;

$app      = JFactory::getApplication();
$user     = JFactory::getUser();
$doc      = JFactory::getDocument();
$lang     = JFactory::getLanguage();
$menu     = $app->getMenu();
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');
$cookie   = $app->input->cookie;

$frontpage_enabled = ($menu->getActive() == $menu->getDefault($lang->getTag()));
$high_contrast_enabled = $cookie->get('high_contrast', false);
$cookie_law_message_enabled = $cookie->get('cookie_law_message', true) == true;
$font_resized = $cookie->get('font_resize', 'small');

if (isset($_GET['toggle_contrast'])) {
  $high_contrast_enabled = !$high_contrast_enabled;
  $cookie->set('high_contrast', $high_contrast_enabled, 0);
}
if (isset($_GET['font_resize'])) {
  $font_resized = $_GET['font_resize'];
  $cookie->set('font_resize', $font_resized, 0);
}
if ($cookie_law_message_enabled) {
  $cookie->set('cookie_law_message', 0, 0);
}

$template_path = $this->baseurl.'/templates/'.$this->template;

$this->setGenerator(null);
$this->setHtml5(true);

$doc->addStyleSheet($template_path . '/css/normalize.css');
$doc->addStyleSheet($template_path . '/css/style.css');
$doc->addScript($template_path . '/js/default.js');

$body_classes =
  "site $option view-$view"
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
  . ($this->direction === 'rtl' ? ' rtl' : '')
  . ($high_contrast_enabled == true? ' high-contrast' : ' low-contrast')
  . ($frontpage_enabled == true? ' frontpage' : ' not-frontpage');

function create_position($position, $show_on_search_results_view = true) {
  global $option;
  if ($show_on_search_results_view && $option != 'com_search'):
    ?><div id="<?php echo $position; ?>" class="position"><div class="content"><jdoc:include type="modules" name="<?php echo $position; ?>" style="none" /></div></div><?php
  endif;
}

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<jdoc:include type="head" />
  <?php if ($font_resized != 'small'): ?>
  <style>html { font-size: <?php echo ($font_resized == 'medium' ? 13 : 16); ?>px; }</style>
  <?php endif; ?>
</head>
<body class="<?php echo $body_classes; ?>">
  <?php create_position('info'); ?>

  <header>
    <div class="content">
        <h1 id="logo"><a href="<?php echo JUri::base(); ?>" title="Strona główna"><?php echo $sitename; ?></a></h1>
        <nav role="navigation"><jdoc:include type="modules" name="nav" style="none" /></nav>

        <div id="facebook">
          <a target="_blank" href="https://www.facebook.com/WeekendNizszychCen/">
            <div id="facebook-logo"></div>
            <span class="hidden-text">Polska Zobacz Więcej na Facebooku</span>
          </a>
        </div>

        <div id="font-resize">
          <a id="font-resize-small" href="<?php echo JUri::current(); ?>?font_resize=small"><span>Czcionka normalna</span></a>
          <a id="font-resize-medium" href="<?php echo JUri::current(); ?>?font_resize=medium"><span>Czcionka średnia</span></a>
          <a id="font-resize-large" href="<?php echo JUri::current(); ?>?font_resize=large"><span>Czcionka duża</span></a>
        </div>

        <div id="contrast">
          <a href="<?php echo JUri::current(); ?>?toggle_contrast=true">Wersja <?php echo $high_contrast_enabled == true ? 'graficzna' : 'kontrastowa'; ?></a>
        </div>
    </div>

    <?php if ($high_contrast_enabled): ?>
    <h1><?php echo $sitename; ?></h1>
    <?php endif; ?>
  </header>

  <div id="video-banner">
    <div class="content">
      <p>Ogólnopolska akcja zniżkowa</p>
	    <p>POLSKA ZOBACZ WIĘCEJ – WEEKEND ZA PÓŁ CENY</p>
	    <p>5 – 7 października 2018</p>
      <a class="btn">Dowiedz się więcej</a>
      <a class="btn">Dodaj ofertę</a>
    </div>
  </div>

  <?php create_position('before_content', false); ?>

  <main role="main">
    <div class="content">
    <jdoc:include type="message" />
    <?php if ($frontpage_enabled == false && $this->countModules('breadcrumbs')) { create_position('breadcrumbs'); } ?>
		<jdoc:include type="component" />
    </div>
  </main>

  <?php create_position('after_content', false); ?>
  <footer role="contentinfo"><?php create_position('footer'); ?></footer>
  <?php create_position('debug'); ?>

</body>
</html>
