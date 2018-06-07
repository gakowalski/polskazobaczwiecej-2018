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
  'site '
  . $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
  . ($this->direction === 'rtl' ? ' rtl' : '')
  . ($high_contrast_enabled == true? ' high-contrast' : ' low-contrast')
  . ($frontpage_enabled == true? ' frontpage' : ' not-frontpage');

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

  <div id="info">
  <jdoc:include type="modules" name="info" style="none" />
  </div>

  <header>
  <jdoc:include type="modules" name="logo" style="none" />
  <nav role="navigation">
    <jdoc:include type="modules" name="nav" style="none" />
  </nav>
  <jdoc:include type="modules" name="header" style="none" />
  </header>

  <?php if ($option != 'com_search'): ?>
  <jdoc:include type="modules" name="before_content" style="none" />
  <?php endif; ?>

  <main role="main">
    <jdoc:include type="message" />

    <?php if ($frontpage_enabled == false && $this->countModules('breadcrumbs')): ?>
      <jdoc:include type="modules" name="breadcrumbs" style="none" />
    <?php endif; ?>

    <?php if ($option != 'com_search'): ?>
      <jdoc:include type="modules" name="content" style="none" />
    <?php endif; ?>

		<jdoc:include type="component" />
  </main>

  <?php if ($option != 'com_search'): ?>
  <jdoc:include type="modules" name="after_content" style="none" />
  <?php endif; ?>

  <footer role="contentinfo">
    <jdoc:include type="modules" name="footer" style="none" />
  </footer>

  <jdoc:include type="modules" name="debug" style="none" />

</body>
</html>
